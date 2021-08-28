<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;

    protected $table = 'admin_log';

    protected $fillable = [
        'old_data',
        'new_data',
        'description',
        'admin_log',
        'action_by',
        'admin_action_by',
    ];
}
