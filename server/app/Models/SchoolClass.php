<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_class';

    protected $fillable = [
        'name',
        'description',
        'school_id',
        'status',
    ];
}
