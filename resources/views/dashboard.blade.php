@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="card" style="background: #1f2937; border: none; border-radius: 15px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);">
                <div class="card-body" style="padding: 30px;">
                    <h5 class="card-title" style="color: #e5e7eb; margin-bottom: 15px;">Total Students</h5>
                    <div class="display-4" style="color: #4f46e5; font-weight: bold;">{{ $studentCount }}</div>
                    <p class="card-text mt-3" style="color: #9ca3af;">Registered students in the system</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card" style="background: #1f2937; border: none; border-radius: 15px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);">
                <div class="card-body" style="padding: 30px;">
                    <h5 class="card-title" style="color: #e5e7eb; margin-bottom: 15px;">Quick Actions</h5>
                    <div class="d-flex gap-3">
                        <a href="{{ route('students.create') }}" class="btn btn-primary" style="background: #4f46e5; border: none; border-radius: 8px; padding: 10px 20px; color: white;">
                            ➕ Add Student
                        </a>
                        <a href="{{ route('students.scanner') }}" class="btn btn-primary" style="background: #4f46e5; border: none; border-radius: 8px; padding: 10px 20px; color: white;">
                            📱 Open Scanner
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
