<?php

use App\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student', [StudentsController::class, 'index'])->name('students.index');
Route::get('/add-student', [StudentsController::class, 'showCreate'])->name('students.create');
Route::get('/students/{student}/generate-qr', [StudentsController::class, 'generateQr'])
    ->name('students.generateQr');
Route::post('/add-student', [StudentsController::class, 'store'])->name('students.store');
Route::get('/scanner', [StudentsController::class, 'scannerPage'])->name('students.scanner');
Route::post('/scanner/lookup', [StudentsController::class, 'lookupStudent'])->name('students.lookup');
