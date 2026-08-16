<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'section',
        'lrn',
        'lrn_hashed'
    ];
}
