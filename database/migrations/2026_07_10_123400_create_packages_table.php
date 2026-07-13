<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price_one_time', 12, 2)->nullable();
            $table->decimal('price_recurring', 12, 2)->nullable();
            $table->string('recurring_interval')->nullable();
            $table->string('currency', 3)->default('NGN');
            $table->boolean('is_recurring')->default(false);
            $table->boolean('most_popular')->default(false);
            $table->string('turnaround_time')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
