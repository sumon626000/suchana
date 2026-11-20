<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicUpload
{
    /**
     * Store an uploaded file under public/uploads/{folder} (Hostinger-safe, no storage link).
     */
    public static function store(UploadedFile $file, string $folder, ?array $allowedExtensions = null): string
    {
        $directory = public_path('uploads/'.$folder);
        File::ensureDirectoryExists($directory);

        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'bin'));
        $allowed = $allowedExtensions ?? ['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf'];
        if (! in_array($extension, $allowed, true)) {
            $extension = $allowed[0] ?? 'bin';
        }

        $filename = Str::uuid()->toString().'.'.$extension;
        $file->move($directory, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }

    public static function delete(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        if (str_starts_with($path, 'uploads/') && File::exists(public_path($path))) {
            File::delete(public_path($path));

            return;
        }

        if (str_starts_with($path, 'images/')) {
            return;
        }

        $legacyStorage = storage_path('app/public/'.$path);
        if (File::exists($legacyStorage)) {
            File::delete($legacyStorage);
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
