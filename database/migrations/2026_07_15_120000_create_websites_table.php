<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // Landing Page, Business Website, etc.
            $table->string('name')->nullable();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('industry')->nullable();
            $table->string('status')->default('draft');
            $table->text('ai_prompt')->nullable();
            $table->string('theme')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
