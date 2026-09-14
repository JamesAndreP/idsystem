@extends('layouts.sidebar')

@section('title', 'Attendance - ' . $gradeAndSection->grade_level . ' ' . $gradeAndSection->section)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="color: #e5e7eb;">Attendance: {{ $gradeAndSection->grade_level }} - {{ $gradeAndSection->section }}</h2>
        <p style="color: #9ca3af;">Date: {{ $today }} | Late Time: {{ substr($lateTime, 0, 5) }}</p>
    </div>
    <a href="{{ route('grade-sections.index') }}" class="btn btn-secondary" style="background: #6b7280; border: none; border-radius: 8px; padding: 8px 16px; color: white;">
        Back to Grade Levels
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); margin-bottom: 20px;">
            <div class="card-header" style="background: #22c55e; color: #fff; padding: 15px 20px;">
                <h4 style="margin: 0; font-weight: 600;">Present ({{ count($present) }})</h4>
            </div>
            <div class="card-body p-0" style="background: #1f2937; max-height: 400px; overflow-y: auto;">
                @if($present->isEmpty())
                    <p class="text-center py-4 text-muted">No students present</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($present as $student)
                            <li class="list-group-item" style="background: #1f2937; border-color: #374151; color: #e5e7eb;">
                                {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); margin-bottom: 20px;">
            <div class="card-header" style="background: #f59e0b; color: #fff; padding: 15px 20px;">
                <h4 style="margin: 0; font-weight: 600;">Late ({{ count($late) }})</h4>
            </div>
            <div class="card-body p-0" style="background: #1f2937; max-height: 400px; overflow-y: auto;">
                @if($late->isEmpty())
                    <p class="text-center py-4 text-muted">No students late</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($late as $student)
                            <li class="list-group-item" style="background: #1f2937; border-color: #374151; color: #e5e7eb;">
                                {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); margin-bottom: 20px;">
            <div class="card-header" style="background: #ef4444; color: #fff; padding: 15px 20px;">
                <h4 style="margin: 0; font-weight: 600;">Absent/Not Attended ({{ count($absent) }})</h4>
            </div>
            <div class="card-body p-0" style="background: #1f2937; max-height: 400px; overflow-y: auto;">
                @if($absent->isEmpty())
                    <p class="text-center py-4 text-muted">No students absent</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($absent as $student)
                            <li class="list-group-item" style="background: #1f2937; border-color: #374151; color: #e5e7eb;">
                                {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .list-group-item {
        padding: 12px 20px;
    }
</style>
