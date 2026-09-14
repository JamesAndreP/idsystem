<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'schoolyear',
        'monday_late_time',
        'tuesday_late_time',
        'wednesday_late_time',
        'thursday_late_time',
        'friday_late_time',
        'saturday_late_time',
        'sunday_late_time',
    ];

    public function getLateTimeForDay($dayName)
    {
        $dayField = strtolower($dayName) . '_late_time';
        return $this->$dayField ?? '08:00:00';
    }
}
