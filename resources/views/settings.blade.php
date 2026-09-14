@extends('layouts.sidebar')

@section('title', 'Settings')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show mb-2">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endforeach
@endif

<div class="card" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); max-width: 600px;">
    <div class="card-header" style="background: #0f172a; color: #fff; padding: 20px;">
        <h3 style="margin: 0; font-weight: 600;">System Settings</h3>
    </div>

    <div class="card-body" style="padding: 30px; background: #1f2937;">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-4">
                <label class="form-label" style="font-weight: 600; color: #e5e7eb;">School Year</label>
                <input type="text" class="form-control" name="schoolyear" value="{{ old('schoolyear', $setting->schoolyear) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                <small class="text-muted" style="color: #9ca3af;">Format: YYYY-YYYY (e.g., 2026-2027)</small>
            </div>

            <hr style="border-color: #374151; margin: 20px 0;">

            <h5 style="color: #e5e7eb; margin-bottom: 15px;">Daily Late Times (PH Time)</h5>
            <small class="text-muted" style="color: #9ca3af; display: block; margin-bottom: 20px;">Configure the time when students are considered late for each day</small>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Monday</label>
                    <input type="time" class="form-control" name="monday_late_time" value="{{ old('monday_late_time', substr($setting->monday_late_time ?? '08:00:00', 0, 5)) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Tuesday</label>
                    <input type="time" class="form-control" name="tuesday_late_time" value="{{ old('tuesday_late_time', substr($setting->tuesday_late_time ?? '08:00:00', 0, 5)) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Wednesday</label>
                    <input type="time" class="form-control" name="wednesday_late_time" value="{{ old('wednesday_late_time', substr($setting->wednesday_late_time ?? '08:00:00', 0, 5)) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Thursday</label>
                    <input type="time" class="form-control" name="thursday_late_time" value="{{ old('thursday_late_time', substr($setting->thursday_late_time ?? '08:00:00', 0, 5)) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Friday</label>
                    <input type="time" class="form-control" name="friday_late_time" value="{{ old('friday_late_time', substr($setting->friday_late_time ?? '08:00:00', 0, 5)) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Saturday</label>
                    <input type="time" class="form-control" name="saturday_late_time" value="{{ old('saturday_late_time', substr($setting->saturday_late_time ?? '08:00:00', 0, 5)) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="font-weight: 600; color: #e5e7eb;">Sunday</label>
                    <input type="time" class="form-control" name="sunday_late_time" value="{{ old('sunday_late_time', substr($setting->sunday_late_time ?? '08:00:00', 0, 5)) }}" required style="border-radius: 10px; padding: 12px; border: 1px solid #374151; background: #111827; color: white;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; border: none; border-radius: 10px; background: #4f46e5; font-weight: 600; color: white;">
                Save Settings
            </button>
        </form>
    </div>
</div>
@endsection
