<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrCreate(['id' => 1]);
        return view('settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'schoolyear' => 'required|string|max:20',
            'monday_late_time' => 'required|date_format:H:i',
            'tuesday_late_time' => 'required|date_format:H:i',
            'wednesday_late_time' => 'required|date_format:H:i',
            'thursday_late_time' => 'required|date_format:H:i',
            'friday_late_time' => 'required|date_format:H:i',
            'saturday_late_time' => 'required|date_format:H:i',
            'sunday_late_time' => 'required|date_format:H:i',
        ]);

        $setting = Setting::firstOrCreate(['id' => 1]);
        $setting->update([
            'schoolyear' => $request->schoolyear,
            'monday_late_time' => $request->monday_late_time . ':00',
            'tuesday_late_time' => $request->tuesday_late_time . ':00',
            'wednesday_late_time' => $request->wednesday_late_time . ':00',
            'thursday_late_time' => $request->thursday_late_time . ':00',
            'friday_late_time' => $request->friday_late_time . ':00',
            'saturday_late_time' => $request->saturday_late_time . ':00',
            'sunday_late_time' => $request->sunday_late_time . ':00',
        ]);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
