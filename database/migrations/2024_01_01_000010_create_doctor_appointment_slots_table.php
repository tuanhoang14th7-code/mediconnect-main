<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_appointment_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_assignment_id')->constrained('doctor_assignments')->cascadeOnDelete();
            $table->foreignId('doctor_schedule_id')->nullable()->constrained('doctor_schedules')->nullOnDelete();
            $table->date('slot_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['Available', 'Held', 'Booked', 'Blocked'])->default('Available');
            $table->timestamp('held_at')->nullable();
            $table->timestamp('booked_at')->nullable();
            $table->string('blocked_reason')->nullable();
            $table->timestamps();

            $table->unique(['doctor_assignment_id', 'slot_date', 'start_time'], 'doctor_appointment_slots_unique');
            $table->index(['slot_date', 'status', 'doctor_assignment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_appointment_slots');
    }
};
