<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLog extends Model
{
    use HasFactory;

    protected $table = 'student_log';

    protected $fillable = [
        'old_data',
        'new_data',
        'description',
        'student_id',
        'action_by',
        'admin_action_by',
    ];
}
