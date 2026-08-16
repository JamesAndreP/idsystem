<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('students.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/student', [StudentsController::class, 'index'])->name('students.index');
    Route::get('/add-student', [StudentsController::class, 'showCreate'])->name('students.create');
    Route::get('/students/{student}/generate-qr', [StudentsController::class, 'generateQr'])
        ->name('students.generateQr');
    Route::post('/add-student', [StudentsController::class, 'store'])->name('students.store');
    Route::get('/scanner', [StudentsController::class, 'scannerPage'])->name('students.scanner');
    Route::post('/scanner/lookup', [StudentsController::class, 'lookupStudent'])->name('students.lookup');
});
