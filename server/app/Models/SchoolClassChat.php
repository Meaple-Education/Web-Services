<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClassChat extends Model
{
    use HasFactory;

    protected $table = 'school_class_chat';

    protected $fillable = [
        'school_class_id',
        'school_teacher_id',
        'school_class_student_id',
        'message',
        'attachement',
        'status',
    ];
}
