<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_hostings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained('websites')->cascadeOnDelete();
            $table->string('hosting_type'); // launchio, own
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_hostings');
    }
};
