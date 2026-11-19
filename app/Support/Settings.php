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

        return asset('storage/'.$path);
    }

    public static function flush(): void
    {
        static::$cache = null;
    }
}
