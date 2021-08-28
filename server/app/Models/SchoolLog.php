<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolLog extends Model
{
    use HasFactory;

    protected $table = 'school_log';

    protected $fillable = [
        'old_data',
        'new_data',
        'description',
        'school_id',
        'action_by',
        'admin_action_by',
    ];
}
