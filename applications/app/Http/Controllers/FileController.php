<?php

namespace App\Http\Controllers;

use App\Models\FileEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index()
    {
        return view('welcome');
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

        // Save chunk
        $chunk = $request->file('chunk');
        Storage::disk('local')->append($tempPath, file_get_contents($chunk->getRealPath()), null);

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

            // Size check (110MB)
            if (Storage::size($finalPath) > 110 * 1024 * 1024) {
                Storage::delete($finalPath);
                return response()->json([
                    'success' => false,
                    'message' => 'File exceeds 110MB limit.',
                ], 413);
            }

            $fileEntry = FileEntry::create([
                'original_name' => $originalName,
                'server_path' => $finalPath,
                'slug' => Str::random(10),
                'password' => $request->password,
                'is_one_time' => $request->boolean('is_one_time'),
                'expires_at' => now()->addHours(24),
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
            $disk = Storage::disk();
            
            // Check if we are on local disk to use deleteFileAfterSend
            $isLocal = config('filesystems.disks.' . config('filesystems.default') . '.driver') === 'local';

            if ($isLocal) {
                $response = response()->download(storage_path('app/' . $fileEntry->server_path), $fileEntry->original_name)
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
}
