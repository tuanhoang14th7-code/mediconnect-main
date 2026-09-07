<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedule_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_assignment_id')->constrained('doctor_assignments')->cascadeOnDelete();
            $table->date('exception_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_available')->default(false);
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->unique(['doctor_assignment_id', 'exception_date', 'start_time', 'end_time'], 'doctor_schedule_exceptions_unique');
            $table->index(['exception_date', 'is_available']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedule_exceptions');
    }
};
