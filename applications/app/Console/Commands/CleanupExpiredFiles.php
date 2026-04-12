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
        $expiredFiles = FileEntry::where('expires_at', '<=', now())->get();

        foreach ($expiredFiles as $file) {
            Storage::delete($file->server_path);
            $file->delete();
            $this->info("Deleted expired file: {$file->original_name}");
        }

        $this->info('Cleanup completed.');
    }
}
