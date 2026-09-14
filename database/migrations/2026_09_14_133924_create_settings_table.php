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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('schoolyear')->default('2026-2027');
            $table->time('monday_late_time')->default('08:00:00');
            $table->time('tuesday_late_time')->default('08:00:00');
            $table->time('wednesday_late_time')->default('08:00:00');
            $table->time('thursday_late_time')->default('08:00:00');
            $table->time('friday_late_time')->default('08:00:00');
            $table->time('saturday_late_time')->default('08:00:00');
            $table->time('sunday_late_time')->default('08:00:00');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
