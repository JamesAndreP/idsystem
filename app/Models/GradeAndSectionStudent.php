<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeAndSectionStudent extends Model
{
    protected $table = 'grade_and_section_students';

    protected $fillable = [
        'grade_and_section_id',
        'student_id',
        'schoolyear',
    ];

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }

    public function gradeAndSection()
    {
        return $this->belongsTo(\App\Models\GradeAndSection::class);
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }
}
