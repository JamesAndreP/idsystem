<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'schoolyear' => '2026-2027',
                'monday_late_time' => '08:00:00',
                'tuesday_late_time' => '08:00:00',
                'wednesday_late_time' => '08:00:00',
                'thursday_late_time' => '08:00:00',
                'friday_late_time' => '08:00:00',
                'saturday_late_time' => '08:00:00',
                'sunday_late_time' => '08:00:00',
            ]
        );
    }
}
