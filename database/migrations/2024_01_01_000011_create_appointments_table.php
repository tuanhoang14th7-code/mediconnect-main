<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_number', 30)->unique();
            $table->foreignId('patient_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('facility_specialization_id')->constrained('facility_specializations')->restrictOnDelete();
            $table->foreignId('doctor_assignment_id')->nullable()->constrained('doctor_assignments')->nullOnDelete();
            $table->foreignId('slot_id')->nullable()->constrained('doctor_appointment_slots')->nullOnDelete();
            $table->string('patient_name');
            $table->string('patient_email')->nullable();
            $table->string('patient_phone', 20);
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('examination_reason')->nullable();
            $table->text('symptoms')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Rejected', 'Cancelled', 'Completed', 'NoShow'])->default('Pending');
            $table->string('rejection_reason', 500)->nullable();
            $table->string('cancellation_reason', 500)->nullable();
            $table->timestamp('booked_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('no_show_at')->nullable();
            $table->timestamp('reminder_created_at')->nullable();
            $table->timestamps();

            $table->index('slot_id');
            $table->index(['patient_user_id', 'status']);
            $table->index(['doctor_assignment_id', 'appointment_date', 'start_time']);
            $table->index(['status', 'appointment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
