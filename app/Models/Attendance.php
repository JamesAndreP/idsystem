<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'grade_and_section_student_id',
        'scanned_at',
        'scan_date',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
        'scan_date' => 'date',
    ];

    public function gradeAndSectionStudent()
    {
        return $this->belongsTo(\App\Models\GradeAndSectionStudent::class);
    }
}
