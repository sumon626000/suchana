<?php

namespace App\Support;

use App\Models\Setting;

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

    public static function flush(): void
    {
        static::$cache = null;
    }
}
