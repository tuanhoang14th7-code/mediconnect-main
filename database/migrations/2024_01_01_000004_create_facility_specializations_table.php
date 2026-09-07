<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facility_specializations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')->constrained('facilities')->cascadeOnDelete();
            $table->foreignId('specialization_id')->constrained('specializations')->restrictOnDelete();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

            $table->unique(['facility_id', 'specialization_id']);
            $table->index(['facility_id', 'status', 'specialization_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facility_specializations');
    }
};
