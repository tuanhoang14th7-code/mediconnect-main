<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities')->restrictOnDelete();
            $table->string('name');
            $table->string('code', 30)->unique();
            $table->string('address', 500);
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

            $table->unique(['city_id', 'name']);
            $table->index(['city_id', 'status', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
