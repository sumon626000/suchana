<?php

namespace App\Models;

use App\Support\Settings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ShowcaseCertificate extends Model
{
    protected $fillable = [
        'title_bn',
        'title_en',
        'subtitle_bn',
        'subtitle_en',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function imageUrl(): string
    {
        return Settings::mediaUrl($this->image);
    }
}
