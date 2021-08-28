<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyValueInfo extends Model
{
    use HasFactory;

    protected $table = 'key_value_info';

    protected $fillable = [
        'key_value_id',
        'language_id',
        'value',
    ];
}
