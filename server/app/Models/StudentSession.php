<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSession extends Model
{
    use HasFactory;

    protected $table = 'student_session';

    protected $fillable = [
        'parent_id',
        'identifier',
        'ip',
        'browser',
        'os',
        'reject_ip',
        'reject_browser',
        'reject_os',
        'is_verify',
        'wrong_attempted',
        'is_valid',
        'last_login',
    ];
}
