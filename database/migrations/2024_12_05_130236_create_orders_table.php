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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['pending', 'paid', 'processed', 'shipped', 'delivered', 'completed', 'cancelled'])->default('pending');
            // $table->unsignedBigInteger('total_product_price');
            // $table->unsignedBigInteger('total_price');
            // $table->string('shipping_address');
            // $table->string('shipping_method')->nullable();
            // $table->unsignedBigInteger('shipping_cost');
            // $table->string('phone_number');
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
