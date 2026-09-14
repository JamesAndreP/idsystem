<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeAndSection extends Model
{
    protected $fillable = [
        'grade_level',
        'section',
    ];

    public function students()
    {
        return $this->belongsToMany(\App\Models\Student::class, 'grade_and_section_students')
                    ->withPivot('schoolyear')
                    ->withTimestamps();
    }
}
