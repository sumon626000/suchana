<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    public function index(): View
    {
        $files = collect(Storage::disk('local')->files('backups'))
            ->map(fn ($path) => [
                'name' => basename($path),
                'path' => $path,
                'size' => Storage::disk('local')->size($path),
                'time' => Storage::disk('local')->lastModified($path),
            ])
            ->sortByDesc('time')
            ->values();

        return view('admin.backups.index', compact('files'));
    }

    public function create(): RedirectResponse
    {
        Artisan::call('db:backup');

        return back()->with('success', 'নতুন ব্যাকআপ তৈরি হয়েছে।');
    }

    public function download(string $file): StreamedResponse
    {
        $path = 'backups/'.basename($file);

        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->download($path);
    }

    public function destroy(string $file): RedirectResponse
    {
        $path = 'backups/'.basename($file);

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
        }

        return back()->with('success', 'ব্যাকআপ মুছে ফেলা হয়েছে।');
    }
}
