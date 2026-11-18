<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
