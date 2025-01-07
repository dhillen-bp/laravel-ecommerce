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
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignUuid('order_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['order_id']);
            $table->dropColumn(['product_id', 'order_id']);
        });
    }
};
