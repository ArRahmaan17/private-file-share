<?php

namespace App\Http\Controllers;

use App\Models\FileEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                if ($request->password === config('app.admin_password')) {
                    session(['admin_auth' => true]);
                    return redirect()->route('admin.index');
                }
                return back()->withErrors(['password' => 'Invalid admin password.']);
            }

            if (session('admin_auth')) {
                return redirect()->route('admin.index');
            }

            return view('admin.login');
        } catch (\Throwable $e) {
            Log::error('Admin Login Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        session()->forget('admin_auth');
        return redirect()->route('admin.login');
    }

    public function index()
    {
        try {
            if (!session('admin_auth')) {
                return redirect()->route('admin.login');
            }

            $files = FileEntry::latest()->get();

            // Storage stats for dashboard cards
            $storagePath = storage_path('app');
            $diskFree = disk_free_space($storagePath);
            $diskTotal = disk_total_space($storagePath);
            $diskUsedPercent = $diskTotal > 0 ? round((1 - $diskFree / $diskTotal) * 100, 1) : 0;

            $totalFileSize = 0;
            foreach ($files as $file) {
                try {
                    $totalFileSize += Storage::size($file->server_path);
                } catch (\Throwable $e) {
                    // File may have been deleted from disk
                }
            }

            return view('admin.index', compact('files', 'diskUsedPercent', 'diskFree', 'diskTotal', 'totalFileSize'));
        } catch (\Throwable $e) {
            Log::error('Admin Dashboard Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_auth')) {
            abort(403);
        }

        $request->validate([
            'expires_at' => 'required|date|after:now',
        ]);

        $fileEntry = FileEntry::findOrFail($id);
        $fileEntry->update([
            'expires_at' => $request->expires_at,
        ]);

        return back()->with('success', 'File expiration updated successfully.');
    }

    public function destroy($id)
    {
        if (!session('admin_auth')) {
            abort(403);
        }

        $fileEntry = FileEntry::findOrFail($id);
        Storage::delete($fileEntry->server_path);
        $fileEntry->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}
