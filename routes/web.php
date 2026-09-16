<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeAndSectionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/student', [StudentsController::class, 'index'])->name('students.index');
    Route::get('/add-student', [StudentsController::class, 'showCreate'])->name('students.create');
    Route::get('/students/{student}/generate-qr', [StudentsController::class, 'generateQr'])
        ->name('students.generateQr');
    Route::post('/add-student', [StudentsController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [StudentsController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentsController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentsController::class, 'destroy'])->name('students.destroy');
    Route::get('/scanner', [StudentsController::class, 'scannerPage'])->name('students.scanner');
    Route::post('/scanner/lookup', [StudentsController::class, 'lookupStudent'])->name('students.lookup');
    Route::get('/grade-sections', [GradeAndSectionController::class, 'index'])->name('grade-sections.index');
    Route::get('/grade-sections/create', [GradeAndSectionController::class, 'showCreate'])->name('grade-sections.create');
    Route::post('/grade-sections', [GradeAndSectionController::class, 'store'])->name('grade-sections.store');
    Route::get('/grade-sections/{id}/edit', [GradeAndSectionController::class, 'edit'])->name('grade-sections.edit');
    Route::put('/grade-sections/{id}', [GradeAndSectionController::class, 'update'])->name('grade-sections.update');
    Route::get('/grade-sections/{id}/attendance', [GradeAndSectionController::class, 'showAttendance'])->name('grade-sections.attendance');
    Route::delete('/grade-sections/{id}', [GradeAndSectionController::class, 'destroy'])->name('grade-sections.destroy');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
