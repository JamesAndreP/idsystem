@extends('layouts.sidebar')

@section('title', 'Edit Grade Level')

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
            <h3 style="margin: 0; font-weight: 600;">Edit Grade Level</h3>
            <a href="{{ route('grade-sections.index') }}" class="btn btn-light" style="background: #4f46e5; border: none; border-radius: 8px; padding: 8px 16px; color: white;">
                Back to List
            </a>
        </div>
    </div>

    <div class="card-body" style="padding: 30px; background: #1f2937;">
        <form action="{{ route('grade-sections.update', $gradeAndSection->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Grade Level</label>
                <input type="text" class="form-control" name="grade_level" value="{{ old('grade_level', $gradeAndSection->grade_level) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                <small class="text-muted" style="color: #9ca3af;">e.g., Grade 7, Grade 8, Grade 9</small>
            </div>

            <div class="mb-4">
                <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Section</label>
                <input type="text" class="form-control" name="section" value="{{ old('section', $gradeAndSection->section) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                <small class="text-muted" style="color: #9ca3af;">e.g., Section A, Section B, Section C</small>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%; padding: 12px; border: none; border-radius: 10px; background: #4f46e5; font-weight: 600; color: white;" onclick="if(this.form.checkValidity()){var btn=this; setTimeout(function(){btn.disabled=true; btn.textContent='Updating...';}, 50);}">
                Update Grade Level
            </button>
        </form>
    </div>
</div>

@if($errors->any())
<script>
    document.getElementById('submitBtn').disabled = false;
    document.getElementById('submitBtn').textContent = 'Update Grade Level';
</script>
@endif
@endsection
