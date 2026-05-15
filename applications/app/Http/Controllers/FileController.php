<?php

namespace App\Http\Controllers;

use App\Models\FileEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    private const MAX_UPLOAD_BYTES = 1024 * 1024 * 1024; // 1 GB
    private const MAX_MISSING_CHUNK_ATTEMPTS = 15;

    public function index()
    {
        $files = FileEntry::all();
        $totalFiles = $files->count();
        $totalSize = 0;

        foreach ($files as $file) {
            try {
                if (Storage::exists($file->server_path)) {
                    $totalSize += Storage::size($file->server_path);
                }
            } catch (\Throwable $e) {
                // Ignore missing files
            }
        }

        return view('welcome', compact('totalFiles', 'totalSize'));
    }

    public function upload(Request $request)
    {
        // Disk safety check (Stop if < 10% free space)
        $freeSpace = disk_free_space(storage_path('app'));
        $totalSpace = disk_total_space(storage_path('app'));
        if ($freeSpace < ($totalSpace * 0.1)) {
            return response()->json([
                'success' => false,
                'message' => 'Server storage is nearly full. Please contact administrator.',
            ], 507);
        }

        // Global Storage Quota Check
        $maxStorageGb = (float) config('filesystems.max_storage_gb', 5);
        $maxStorageBytes = $maxStorageGb * 1024 * 1024 * 1024;
        $currentStorageBytes = $this->getDirectorySize(Storage::disk('local')->path('uploads'));

        if (($currentStorageBytes + $request->file('chunk')->getSize()) > $maxStorageBytes) {
            return response()->json([
                'success' => false,
                'message' => 'System storage quota reached. Please try again later.',
            ], 507);
        }

        $request->validate([
            'chunk' => 'required|file',
            'index' => 'required|integer',
            'total_chunks' => 'required|integer',
            'uuid' => 'required|string',
            'original_name' => 'required|string',
            'password' => 'nullable|string|max:255',
            'is_one_time' => 'string', // Passed as "1" or "0"
        ]);

        $uuid = $request->uuid;
        $index = (int) $request->index;
        $totalChunks = (int) $request->total_chunks;
        $originalName = $request->original_name;
        $tempPath = "chunks/{$uuid}";
        $disk = Storage::disk('local');

        if ($index < 0 || $totalChunks < 1 || $index >= $totalChunks) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid chunk sequence.',
            ], 422);
        }

        if ($index > 0 && !$disk->exists($tempPath)) {
            return $this->rejectMissingChunkSession($uuid, $request->ip());
        }

        Cache::forget($this->missingChunkAttemptKey($uuid, $request->ip()));

        // Save chunk
        $chunk = $request->file('chunk');
        $this->appendChunkToTempFile($tempPath, $chunk->getRealPath(), $index === 0);

        // If it was the last chunk
        if ($index + 1 === $totalChunks) {
            $finalPath = "uploads/" . Str::random(40);
            
            // Move from chunks to uploads (Storage rename doesn't support local disk appending easily, 
            // but append moved and merged it effectively already in the loop above)
            Storage::move($tempPath, $finalPath);

            // Validation for common file types
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowedExtensions = ['pdf', 'zip', 'rar', '7z', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'txt', 'csv', 'mp4', 'mp3'];
            
            if (!in_array($extension, $allowedExtensions)) {
                Storage::delete($finalPath);
                return response()->json([
                    'success' => false,
                    'message' => 'File type not allowed. Allowed types: ' . implode(', ', $allowedExtensions),
                ], 422);
            }

            // Size check (1GB)
            if (Storage::size($finalPath) > self::MAX_UPLOAD_BYTES) {
                Storage::delete($finalPath);
                return response()->json([
                    'success' => false,
                    'message' => 'File exceeds 1GB limit.',
                ], 413);
            }

            $fileEntry = FileEntry::create([
                'original_name' => $originalName,
                'server_path' => $finalPath,
                'slug' => Str::random(10),
                'password' => $request->password,
                'is_one_time' => $request->boolean('is_one_time'),
                'expires_at' => now()->addHour(),
            ]);

            return response()->json([
                'success' => true,
                'done' => true,
                'slug' => $fileEntry->slug,
                'download_link' => route('show', $fileEntry->slug),
            ]);
        }

        return response()->json([
            'success' => true,
            'done' => false,
            'message' => "Chunk {$index} uploaded",
        ]);
    }

    public function show($slug)
    {
        $fileEntry = FileEntry::where('slug', $slug)->firstOrFail();

        if ($fileEntry->expires_at->isPast()) {
            $this->cleanup($fileEntry);
            abort(404, 'The requested link has expired.');
        }

        return view('download', compact('fileEntry'));
    }

    public function download(Request $request, $slug)
    {
        $fileEntry = FileEntry::where('slug', $slug)->firstOrFail();

        if ($fileEntry->expires_at->isPast()) {
            $this->cleanup($fileEntry);
            abort(404, 'The requested link has expired.');
        }

        if ($fileEntry->password) {
            if ($request->password !== $fileEntry->password) {
                return back()->withErrors(['password' => 'Invalid password.']);
            }
        }

        if ($fileEntry->is_one_time) {
            // Check if we are on local disk to use deleteFileAfterSend
            $isLocal = config('filesystems.disks.' . config('filesystems.default') . '.driver') === 'local';

            if ($isLocal) {
                $response = response()->download(storage_path('app/private/' . $fileEntry->server_path), $fileEntry->original_name)
                    ->deleteFileAfterSend(true);
            } else {
                $response = Storage::download($fileEntry->server_path, $fileEntry->original_name);
                Storage::delete($fileEntry->server_path);
            }

            $fileEntry->delete();
            return $response;
        }

        return Storage::download($fileEntry->server_path, $fileEntry->original_name);
    }

    private function cleanup($fileEntry)
    {
        Storage::delete($fileEntry->server_path);
        $fileEntry->delete();
    }

    private function rejectMissingChunkSession(string $uuid, ?string $ip)
    {
        $cacheKey = $this->missingChunkAttemptKey($uuid, $ip);
        $attempts = Cache::store()->add($cacheKey, 0, now()->addMinutes(15))
            ? 0
            : (int) Cache::get($cacheKey, 0);

        $attempts = Cache::increment($cacheKey);

        $status = $attempts >= self::MAX_MISSING_CHUNK_ATTEMPTS ? 429 : 409;
        $message = $attempts >= self::MAX_MISSING_CHUNK_ATTEMPTS
            ? 'Upload session rejected after 15 invalid chunk attempts. Start again.'
            : 'Upload session not found. Restart the upload.';

        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    private function missingChunkAttemptKey(string $uuid, ?string $ip): string
    {
        return 'upload:missing-chunk:' . $uuid . ':' . sha1($ip ?? 'unknown');
    }

    private function appendChunkToTempFile(string $tempPath, string $sourcePath, bool $truncate = false): void
    {
        $destinationPath = Storage::disk('local')->path($tempPath);
        $destinationDir = dirname($destinationPath);

        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $source = fopen($sourcePath, 'rb');
        $destination = fopen($destinationPath, $truncate ? 'wb' : 'ab');

        if ($source === false || $destination === false) {
            if (is_resource($source)) {
                fclose($source);
            }
            if (is_resource($destination)) {
                fclose($destination);
            }

            throw new \RuntimeException('Unable to write upload chunk.');
        }

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

    private function getDirectorySize($path)
    {
        $size = 0;
        if (!is_dir($path)) return 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
}
