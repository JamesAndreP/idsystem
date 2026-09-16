<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\GradeAndSection;
use App\Models\GradeAndSectionStudent;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeAndSectionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = GradeAndSection::orderBy('grade_level')->orderBy('section');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('grade_level', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%");
            });
        }

        $gradeAndSections = $query->paginate(20);

        return view('grade-sections', [
            'gradeAndSections' => $gradeAndSections,
            'search' => $search
        ]);
    }

    public function showCreate()
    {
        return view('add-grade-section');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade_level' => 'required|string|max:50',
            'section' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        GradeAndSection::create([
            'grade_level' => $request->grade_level,
            'section' => $request->section,
        ]);

        return redirect()->route('grade-sections.index')->with('success', 'Grade and section created successfully!');
    }

    public function edit($id)
    {
        $gradeAndSection = GradeAndSection::findOrFail($id);
        return view('edit-grade-section', compact('gradeAndSection'));
    }

    public function update(Request $request, $id)
    {
        $gradeAndSection = GradeAndSection::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'grade_level' => 'required|string|max:50',
            'section' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $gradeAndSection->update([
            'grade_level' => $request->grade_level,
            'section' => $request->section,
        ]);

        return redirect()->route('grade-sections.index')->with('success', 'Grade and section updated successfully!');
    }

    public function showAttendance($id)
    {
        $gradeAndSection = GradeAndSection::with(['students', 'students.currentGradeAndSection'])->findOrFail($id);
        $setting = Setting::first();
        $timezone = 'Asia/Manila';
        $today = now()->setTimezone($timezone)->toDateString();
        $dayName = now()->setTimezone($timezone)->format('l'); // Monday, Tuesday, etc.
        $lateTime = $setting->getLateTimeForDay($dayName);

        // Get all students assigned to this grade/section for current school year
        $students = Student::whereHas('currentGradeAndSection', function($query) use ($gradeAndSection) {
            $query->where('grade_and_sections.id', $gradeAndSection->id);
        })->with('currentGradeAndSection')->get();

        $present = collect();
        $late = collect();
        $absent = collect();

        foreach ($students as $student) {
            // Get the grade and section student record
            $gradeSectionStudent = GradeAndSectionStudent::where('student_id', $student->id)
                ->where('grade_and_section_id', $gradeAndSection->id)
                ->where('schoolyear', $setting->schoolyear)
                ->first();

            if ($gradeSectionStudent) {
                // Check attendance for today
                $attendance = Attendance::where('grade_and_section_student_id', $gradeSectionStudent->id)
                    ->where('scan_date', $today)
                    ->first();

                if ($attendance) {
                    // Determine if late based on scan time
                    $scanTime = $attendance->scanned_at->setTimezone($timezone)->format('H:i');
                    $scanTimeFormatted = $attendance->scanned_at->setTimezone($timezone)->format('h:i:s A');
                    if ($scanTime > substr($lateTime, 0, 5)) {
                        // Calculate elapsed minutes
                        $lateTimeCarbon = \Carbon\Carbon::createFromFormat('H:i', substr($lateTime, 0, 5), $timezone);
                        $scanTimeCarbon = $attendance->scanned_at->setTimezone($timezone);
                        $elapsedMinutes = $lateTimeCarbon->diffInMinutes($scanTimeCarbon);
                        
                        $late->push([
                            'student' => $student,
                            'scan_time' => $scanTimeFormatted,
                            'elapsed_minutes' => ceil($elapsedMinutes)
                        ]);
                    } else {
                        $present->push([
                            'student' => $student,
                            'scan_time' => $scanTimeFormatted
                        ]);
                    }
                } else {
                    $absent->push($student);
                }
            } else {
                $absent->push($student);
            }
        }

        return view('attendance', compact('gradeAndSection', 'present', 'late', 'absent', 'today', 'lateTime', 'timezone'));
    }

    public function destroy($id)
    {
        $gradeAndSection = GradeAndSection::findOrFail($id);
        $gradeAndSection->delete();

        return redirect()->route('grade-sections.index')->with('success', 'Grade and section deleted successfully!');
    }
}
