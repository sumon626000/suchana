<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = ['title_bn', 'title_en', 'body_bn', 'body_en', 'type', 'published_at', 'is_active'];

    protected $casts = ['published_at' => 'datetime', 'is_active' => 'boolean'];
}
