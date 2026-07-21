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
        Schema::table('websites', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->after('user_id')->constrained()->cascadeOnDelete();
            $table->string('url')->nullable()->after('theme');
            $table->text('admin_login')->nullable()->after('url');
            $table->timestamp('sent_at')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropConstrainedForeignId('order_id');
            $table->dropColumn(['url', 'admin_login', 'sent_at', 'approved_at']);
        });
    }
};
