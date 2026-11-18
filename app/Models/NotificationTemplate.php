<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $fillable = ['key', 'channel', 'subject', 'body_bn', 'body_en', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
