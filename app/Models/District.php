<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $fillable = ['name_bn', 'name_en', 'division_bn', 'division_en'];

    public function thanas(): HasMany
    {
        return $this->hasMany(Thana::class);
    }
}
