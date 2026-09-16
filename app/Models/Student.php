<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'lrn',
        'lrn_hashed',
    ];

    public function gradeAndSections()
    {
        return $this->belongsToMany(\App\Models\GradeAndSection::class, 'grade_and_section_students')
                    ->withPivot('schoolyear')
                    ->withTimestamps();
    }

    public function currentGradeAndSection()
    {
        $setting = \App\Models\Setting::first();
        $schoolyear = $setting ? $setting->schoolyear : '2026-2027';
        return $this->belongsToMany(\App\Models\GradeAndSection::class, 'grade_and_section_students')
                    ->withPivot('schoolyear')
                    ->wherePivot('schoolyear', $schoolyear)
                    ->withTimestamps();
    }

    public function getCurrentGradeAndSectionAttribute()
    {
        return $this->currentGradeAndSection()->first();
    }
}
