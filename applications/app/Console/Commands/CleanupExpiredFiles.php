<?php

namespace App\Console\Commands;

use App\Models\FileEntry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupExpiredFiles extends Command
{
    protected $signature = 'files:cleanup';
    protected $description = 'Delete files that have expired after 24 hours';

    public function handle()
    {
        // 1. Cleanup expired file entries
        $expiredFiles = FileEntry::where('expires_at', '<=', now())->get();
        $count = $expiredFiles->count();

        foreach ($expiredFiles as $file) {
            if (Storage::exists($file->server_path)) {
                Storage::delete($file->server_path);
            }
            $file->delete();
            $this->info("Deleted expired file: {$file->original_name}");
        }

        // 2. Cleanup orphaned chunks (abandoned uploads) older than 2 hours
        $chunkDirs = Storage::directories('chunks');
        $orphanCount = 0;
        foreach ($chunkDirs as $dir) {
            // Check directory last modified time
            $time = Storage::lastModified($dir);
            if (now()->timestamp - $time > 7200) { // 2 hours
                Storage::deleteDirectory($dir);
                $orphanCount++;
            }
        }

        $this->info("Cleanup completed. Deleted {$count} files and {$orphanCount} orphaned chunk sessions.");
    }
}
