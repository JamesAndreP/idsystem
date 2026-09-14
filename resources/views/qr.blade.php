@extends('layouts.sidebar')

@section('title', 'Student QR Print')

@section('content')
<div class="card" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); max-width: 500px; margin: auto;">
    <div class="card-body" style="padding: 25px; background: #1f2937; text-align: center;">

        <h3 style="color: #e1e3e7;">Student QR Code</h3>

        <div style="margin: 20px 0;">
            {!! $qr !!}
        </div>

        <div style="text-align: left; margin-top: 15px;">
            <p style="margin: 5px 0; font-size: 15px; color: #e5e7eb;"><strong>First Name:</strong> {{ $student->first_name }}</p>
            <p style="margin: 5px 0; font-size: 15px; color: #e5e7eb;"><strong>Middle Name:</strong> {{ $student->middle_name ?: '-' }}</p>
            <p style="margin: 5px 0; font-size: 15px; color: #e5e7eb;"><strong>Last Name:</strong> {{ $student->last_name }}</p>
            <p style="margin: 5px 0; font-size: 15px; color: #e5e7eb;"><strong>Grade & Section:</strong> {{ $student->currentGradeAndSection ? $student->currentGradeAndSection->grade_level . ' - ' . $student->currentGradeAndSection->section : 'Not assigned' }}</p>
            <p style="margin: 5px 0; font-size: 15px; color: #e5e7eb;"><strong>LRN:</strong> {{ $student->lrn }}</p>
        </div>

        <div class="d-flex gap-2" style="margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-primary flex-grow-1" style="background: #4f46e5; border: none; color: white;">
                Print
            </button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary flex-grow-1" style="background: #6b7280; border: none; color: white;">
                Back to List
            </a>
        </div>

    </div>
</div>

<style>
    .d-flex {
        display: flex;
        gap: 10px;
    }

    .flex-grow-1 {
        flex-grow: 1;
    }

    /* PRINT STYLES */
    @media print {
        body {
            background: white !important;
            color: black !important;
        }

        .sidebar {
            display: none !important;
        }

        .main-content {
            padding: 0 !important;
        }

        .card {
            background: white !important;
            box-shadow: none !important;
            border: none !important;
        }

        .card-body {
            background: white !important;
            color: black !important;
        }

        .d-flex {
            display: none !important;
        }

        p {
            color: black !important;
        }
    }
</style>
@endsection
