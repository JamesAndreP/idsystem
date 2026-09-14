<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_and_section_student_id')->constrained('grade_and_section_students')->onDelete('cascade');
            $table->timestampTz('scanned_at')->useCurrent();
            $table->date('scan_date')->useCurrent();
            $table->timestampsTz();

            $table->unique(['grade_and_section_student_id', 'scan_date'], 'attendance_unique_per_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
