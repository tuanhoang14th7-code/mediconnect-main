<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('facility_specialization_id')->constrained('facility_specializations')->restrictOnDelete();
            $table->string('room_number', 50)->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

            $table->unique(['doctor_id', 'facility_specialization_id']);
            $table->index(['facility_specialization_id', 'status', 'doctor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_assignments');
    }
};
