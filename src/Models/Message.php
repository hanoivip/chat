<?php

namespace Hanoivip\Chat\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message'];
    
    protected $hidden = ['id', 'user_id', 'is_read', 'updated_at'];
}
