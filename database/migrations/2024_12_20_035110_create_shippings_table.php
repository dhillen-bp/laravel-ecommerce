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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('order_id')->references('id')->on('orders')->onUpdate('cascade');
            $table->foreignId('province_id')->constrained('provinces')->onUpdate('cascade');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('cost');
            // $table->decimal('cost', 10, 2)->nullable();
            $table->string('courier_name')->nullable();
            $table->string('courier_code')->nullable();
            $table->string('courier_service')->nullable();
            $table->string('courier_service_description')->nullable();
            $table->string('estimate_day')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
