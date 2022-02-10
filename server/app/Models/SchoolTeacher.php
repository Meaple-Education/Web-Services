<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolTeacher extends Model
{
    /*
        role
        - 1 owner
        - 2 teacher
    */
    use HasFactory;

    protected $table = 'school_teacher';

    protected $fillable = [
        'school_id',
        'user_id',
        'status',
        'role',
        'lock',
    ];
}
