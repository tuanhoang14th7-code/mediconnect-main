<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('content_type', ['Disease', 'Prevention', 'Cure', 'MedicalNews', 'MedicalInvention']);
            $table->string('title');
            $table->string('slug', 280)->unique();
            $table->text('summary')->nullable();
            $table->longText('body');
            $table->string('featured_image')->nullable();
            $table->string('source_url', 1000)->nullable();
            $table->enum('status', ['Draft', 'Published', 'Archived'])->default('Draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['content_type', 'status', 'published_at']);
            $table->index('author_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_contents');
    }
};
