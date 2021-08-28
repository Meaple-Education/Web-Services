<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClassSubject extends Model
{
    use HasFactory;

    protected $table = 'school_class_subject';

    protected $fillable = [
        'name',
        'description',
        'school_class_id',
        'status',
    ];
}
