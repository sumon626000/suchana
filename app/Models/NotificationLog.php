<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $fillable = ['template_key', 'channel', 'recipient', 'message', 'status'];
}
