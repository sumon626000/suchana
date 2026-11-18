<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = ['name', 'designation', 'photo', 'bio', 'phone', 'email', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];
}
