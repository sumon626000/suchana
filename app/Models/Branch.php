<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name_bn', 'name_en', 'address', 'phone', 'email', 'image', 'map_url', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];
}
