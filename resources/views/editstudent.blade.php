@extends('layouts.sidebar')

@section('title', 'Edit Student')

@section('content')
@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endforeach
@endif

<div class="card" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); max-width: 600px;">
    <div class="card-header" style="background: #0f172a; color: #fff; padding: 20px;">
        <div class="d-flex justify-content-between align-items-center">
            <h3 style="margin: 0; font-weight: 600;">Edit Student</h3>
            <a href="{{ route('students.index') }}" class="btn btn-light" style="background: #4f46e5; border: none; border-radius: 8px; padding: 8px 16px; color: white;">
                Back to List
            </a>
        </div>
    </div>

    <div class="card-body" style="padding: 30px; background: #1f2937;">
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label" style="font-weight: 600; color: #e5e7eb;">First Name</label>
                <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $student->first_name) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Middle Name</label>
                <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $student->middle_name) }}" style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Last Name</label>
                <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $student->last_name) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Grade & Section</label>
                <select class="form-control" name="grade_and_section_id" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                    <option value="">Select Grade & Section</option>
                    @foreach($gradeAndSections as $gradeAndSection)
                        <option value="{{ $gradeAndSection->id }}" {{ (old('grade_and_section_id', $student->currentGradeAndSection?->id) == $gradeAndSection->id) ? 'selected' : '' }}>
                            {{ $gradeAndSection->grade_level }} - {{ $gradeAndSection->section }}
                        </option>
                    @endforeach
                </select>
                @if($gradeAndSections->isEmpty())
                    <small class="text-danger">No grade levels available. Please add grade levels first.</small>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label" style="font-weight: 600; color: #e5e7eb;">LRN</label>
                <input type="text" class="form-control" name="lrn" value="{{ old('lrn', $student->lrn) }}" maxlength="12" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%; padding: 12px; border: none; border-radius: 10px; background: #4f46e5; font-weight: 600; color: white;" onclick="if(this.form.checkValidity()){var btn=this; setTimeout(function(){btn.disabled=true; btn.textContent='Updating...';}, 50);}">
                Update Student
            </button>
        </form>
    </div>
</div>

@if($errors->any())
<script>
    document.getElementById('submitBtn').disabled = false;
    document.getElementById('submitBtn').textContent = 'Update Student';
</script>
@endif
@endsection
