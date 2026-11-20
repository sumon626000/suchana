<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\File;

class Settings
{
    protected static ?array $cache = null;

    public static function all(): array
    {
        if (static::$cache === null) {
            static::$cache = Setting::pluck('value', 'key')->toArray();
        }

        return static::$cache;
    }

    public static function get(string $key, $default = null)
    {
        $value = static::all()[$key] ?? null;

        return ($value === null || $value === '') ? $default : $value;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $value = static::all()[$key] ?? null;

        if ($value === null) {
            return $default;
        }

        return in_array($value, ['1', 'true', 'on', 'yes'], true);
    }

    public static function mediaUrl(?string $path, ?string $fallback = null): string
    {
        if (! $path) {
            return $fallback ?? asset('images/logo-suchana.jpg');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return asset(ltrim($path, '/'));
        }

        if (str_starts_with($path, 'uploads/') || str_starts_with($path, 'images/')) {
            return asset($path);
        }

        $uploadPath = 'uploads/'.$path;
        if (File::exists(public_path($uploadPath))) {
            return asset($uploadPath);
        }

        // Legacy public-disk paths (e.g. branding/xxx.jpg). Hostinger often has no
        // storage:link, so mirror into public/uploads and serve from there.
        $legacyStorage = storage_path('app/public/'.$path);
        if (File::exists($legacyStorage)) {
            $mirror = 'uploads/'.$path;
            $mirrorFull = public_path($mirror);
            if (! File::exists($mirrorFull)) {
                File::ensureDirectoryExists(dirname($mirrorFull));
                File::copy($legacyStorage, $mirrorFull);
            }

            return asset($mirror);
        }

        // Last resort: known default logos if a broken relative path was saved.
        if (str_contains($path, 'sfdb')) {
            return $fallback ?? asset('images/logo-sfdb.jpg');
        }

        return $fallback ?? asset('storage/'.$path);
    }

    public static function logoUrl(?string $path, string $fallbackAsset): string
    {
        if (! $path) {
            return asset($fallbackAsset);
        }

        $url = static::mediaUrl($path, asset($fallbackAsset));

        // If still pointing at /storage/... which 404s on Hostinger, fall back.
        if (str_contains($url, '/storage/')) {
            return asset($fallbackAsset);
        }

        return $url;
    }

    /**
     * Normalize a Bangladesh (or intl) phone into WhatsApp digits (e.g. 8801XXXXXXXXX).
     */
    public static function whatsappDigits(?string $raw): string
    {
        if ($raw === null || trim($raw) === '') {
            return '';
        }

        $raw = trim($raw);

        // Allow pasting full wa.me / api.whatsapp.com links.
        if (preg_match('/wa\.me\/(\+?\d+)/i', $raw, $m) || preg_match('/phone=(\+?\d+)/i', $raw, $m)) {
            $raw = $m[1];
        }

        $digits = preg_replace('/\D+/', '', $raw) ?? '';

        if ($digits === '') {
            return '';
        }

        // 01XXXXXXXXX → 8801XXXXXXXXX
        if (preg_match('/^01\d{9}$/', $digits)) {
            return '88'.$digits;
        }

        // 1XXXXXXXXX (10 digits, missing leading 0) → 8801XXXXXXXXX
        if (preg_match('/^1\d{9}$/', $digits)) {
            return '880'.$digits;
        }

        // Already 8801XXXXXXXXX
        if (preg_match('/^8801\d{9}$/', $digits)) {
            return $digits;
        }

        // 880 + other / generic intl — keep digits as-is
        return $digits;
    }

    public static function absoluteUrl(?string $url): string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        if (str_starts_with($url, '//')) {
            return 'https:'.$url;
        }

        return 'https://'.$url;
    }

    public static function flush(): void
    {
        static::$cache = null;
    }
}
