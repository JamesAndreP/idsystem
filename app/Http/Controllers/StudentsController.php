<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentsController extends Controller
{
    //
    public function index(Request $request)
    {
        $students = Student::orderBy('created_at', 'desc')->get();
        return view('student')->with([
            'students' => $students
        ]);
    }
    public function showCreate(Request $request)
    {
        return view('addstudent');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'lrn' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lrn_hashed = $request->last_name . $request->section . $request->lrn;

        Student::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'section' => $request->section,
            'lrn' => $request->lrn,
            'lrn_hashed' => $lrn_hashed,
        ]);

        return redirect()->back()->with('success', 'Student created successfully!');
    }

    public function generateQr(int $id)
    {
        $student = Student::findOrFail($id);

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

        $student = Student::where('lrn_hashed', $request->code)
            ->orWhere('lrn', $request->code)
            ->first();

        if (!$student) {
            return response()->json([
                'status' => 'not_found'
            ]);
        }

        return response()->json([
            'status' => 'found',
            'student' => $student
        ]);
    }
}
