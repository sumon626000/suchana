<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = ['name', 'designation', 'photo', 'bio', 'phone', 'email', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function photoUrl(): ?string
    {
        $photo = $this->photo;

        if (! $photo) {
            return null;
        }

        if (str_starts_with($photo, 'http://') || str_starts_with($photo, 'https://')) {
            return $photo;
        }

        if (str_starts_with($photo, '/')) {
            return asset(ltrim($photo, '/'));
        }

        if (str_starts_with($photo, 'uploads/')) {
            return asset($photo);
        }

        // Legacy public-disk paths (staff/xxx.jpg) — prefer public/uploads copy if present.
        $uploadPath = 'uploads/'.$photo;
        if (File::exists(public_path($uploadPath))) {
            return asset($uploadPath);
        }

        return asset('storage/'.$photo);
    }
}
