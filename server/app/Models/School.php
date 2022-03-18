<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'school';

    protected $fillable = [
        'name',
        'logo',
        'status',
        'description',
        'address',
        'phone_numbers',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($school) {
            SchoolTeacher::create([
                'school_id' => $school->id,
                'user_id' => $school->user_id,
                'status' => 1,
                'role' => 1,
                'lock' => 1,
            ]);
        });
    }
}
