<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\GradeAndSection;
use App\Models\GradeAndSectionStudent;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentsController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Student::with('currentGradeAndSection')->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('lrn', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate(20);

        return view('student')->with([
            'students' => $students,
            'search' => $search
        ]);
    }
    public function showCreate(Request $request)
    {
        $gradeAndSections = GradeAndSection::orderBy('grade_level')->orderBy('section')->get();
        return view('addstudent', compact('gradeAndSections'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'lrn' => 'required|string|max:255|unique:students,lrn',
            'grade_and_section_id' => 'required|exists:grade_and_sections,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lrn_hashed = $request->last_name . $request->lrn;

        $student = Student::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'lrn' => $request->lrn,
            'lrn_hashed' => $lrn_hashed,
        ]);

        $schoolyear = Setting::first()->schoolyear ?? '2026-2027';
        $student->gradeAndSections()->attach($request->grade_and_section_id, ['schoolyear' => $schoolyear]);

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }

    public function edit($id)
    {
        $student = Student::with('currentGradeAndSection')->findOrFail($id);
        $gradeAndSections = GradeAndSection::orderBy('grade_level')->orderBy('section')->get();
        return view('editstudent', compact('student', 'gradeAndSections'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'lrn' => 'required|string|max:255|unique:students,lrn,' . $id,
            'grade_and_section_id' => 'required|exists:grade_and_sections,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lrn_hashed = $request->last_name . $request->lrn;

        $student->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'lrn' => $request->lrn,
            'lrn_hashed' => $lrn_hashed,
        ]);

        $schoolyear = Setting::first()->schoolyear ?? '2026-2027';

        // Update grade and section assignment
        $student->gradeAndSections()->wherePivot('schoolyear', $schoolyear)->detach();
        $student->gradeAndSections()->attach($request->grade_and_section_id, ['schoolyear' => $schoolyear]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }

    public function generateQr(int $id)
    {
        $student = Student::with('currentGradeAndSection')->findOrFail($id);

        $qr = QrCode::size(250)->generate($student->lrn_hashed);

        return view('qr', compact('student', 'qr'));
    }

    public function scannerPage()
    {
        return view('scanner');
    }

    public function lookupStudent(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $student = Student::with('currentGradeAndSection')->where('lrn_hashed', $request->code)
            ->orWhere('lrn', $request->code)
            ->first();

        if (!$student) {
            return response()->json([
                'status' => 'not_found'
            ]);
        }

        // Get current grade and section student record
        $currentGradeSection = $student->currentGradeAndSection()->first();
        if (!$currentGradeSection) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Student not assigned to any grade/section for current school year'
            ]);
        }

        // Get the pivot record from the relationship
        $gradeSectionStudent = GradeAndSectionStudent::where('student_id', $student->id)
            ->where('grade_and_section_id', $currentGradeSection->id)
            ->where('schoolyear', $currentGradeSection->pivot->schoolyear)
            ->first();

        if (!$gradeSectionStudent) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Grade/section assignment not found'
            ]);
        }

        // Check if attendance already exists for today (using UTC+8 for Philippines)
        $timezone = 'Asia/Manila'; // Philippines timezone (UTC+8)
        $todayLocal = now()->setTimezone($timezone)->toDateString();
        
        $existingAttendance = Attendance::where('grade_and_section_student_id', $gradeSectionStudent->id)
            ->where('scan_date', $todayLocal)
            ->first();

        if (!$existingAttendance) {
            // Create new attendance record with local timezone date
            Attendance::create([
                'grade_and_section_student_id' => $gradeSectionStudent->id,
                'scanned_at' => now(),
                'scan_date' => $todayLocal,
            ]);
        }

        return response()->json([
            'status' => 'found',
            'student' => $student,
            'attendance' => $existingAttendance ?? 'new'
        ]);
    }
}
