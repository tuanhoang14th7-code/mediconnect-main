<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->foreignId('changed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('action', ['Created', 'Confirmed', 'Adjusted', 'Rejected', 'RescheduleRequested', 'Cancelled', 'Completed', 'NoShow']);
            $table->enum('old_status', ['Pending', 'Confirmed', 'Rejected', 'Cancelled', 'Completed', 'NoShow'])->nullable();
            $table->enum('new_status', ['Pending', 'Confirmed', 'Rejected', 'Cancelled', 'Completed', 'NoShow']);
            $table->foreignId('old_doctor_assignment_id')->nullable()->constrained('doctor_assignments')->nullOnDelete();
            $table->foreignId('new_doctor_assignment_id')->nullable()->constrained('doctor_assignments')->nullOnDelete();
            $table->foreignId('old_slot_id')->nullable()->constrained('doctor_appointment_slots')->nullOnDelete();
            $table->foreignId('new_slot_id')->nullable()->constrained('doctor_appointment_slots')->nullOnDelete();
            $table->string('note', 500)->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index(['appointment_id', 'created_at']);
            $table->index('changed_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_histories');
    }
};
