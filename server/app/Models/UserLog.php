<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = 'user_log';

    protected $fillable = [
        'old_data',
        'new_data',
        'description',
        'user_id',
        'action_by',
        'admin_action_by',
    ];
}
