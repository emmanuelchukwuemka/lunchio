<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_ecommerce_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained('websites')->cascadeOnDelete();
            $table->string('product_type')->nullable(); // Physical, Digital, Both
            $table->string('num_products')->nullable();
            $table->json('categories')->nullable();
            $table->json('payment_methods')->nullable();
            $table->string('shipping')->nullable();
            $table->string('inventory_tracking')->nullable();
            $table->boolean('coupons_enabled')->default(false);
            $table->boolean('wishlist_enabled')->default(false);
            $table->boolean('product_reviews_enabled')->default(false);
            $table->boolean('related_products_enabled')->default(false);
            $table->boolean('customer_accounts')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_ecommerce_settings');
    }
};
