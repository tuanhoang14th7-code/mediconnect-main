<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('expertise');
            $table->unsignedSmallInteger('experience')->default(0);
            $table->string('education');
            $table->text('qualifications')->nullable();
            $table->string('profession');
            $table->string('license_number', 100)->nullable()->unique();
            $table->text('bio')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

            $table->index(['status', 'expertise']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
