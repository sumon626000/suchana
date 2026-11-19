<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;

class Course extends Model
{
    protected $fillable = [
        'name_bn', 'name_en', 'level', 'duration_bn', 'duration_en',
        'eligibility_bn', 'eligibility_en', 'description_bn', 'description_en',
        'seats_total', 'seats_available', 'fee', 'stipend_male', 'stipend_female',
        'image', 'application_deadline', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'application_deadline' => 'date',
        'fee' => 'decimal:2',
        'stipend_male' => 'decimal:2',
        'stipend_female' => 'decimal:2',
    ];

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function imageUrl(): string
    {
        $image = $this->image;

        if (! $image) {
            return asset('images/logo-suchana.jpg');
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        if (str_starts_with($image, '/')) {
            return asset(ltrim($image, '/'));
        }

        if (str_starts_with($image, 'uploads/') || str_starts_with($image, 'images/')) {
            return asset($image);
        }

        $uploadPath = 'uploads/'.$image;
        if (File::exists(public_path($uploadPath))) {
            return asset($uploadPath);
        }

        return asset('storage/'.$image);
    }
}
