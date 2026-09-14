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
        Schema::create('grade_and_section_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_and_section_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('schoolyear');
            $table->timestampsTz();

            $table->unique(['grade_and_section_id', 'student_id', 'schoolyear'], 'grade_section_student_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_and_section_students');
    }
};
