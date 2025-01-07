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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('discount_code')->nullable()->after('status')->comment('Code of the applied discount');
            $table->unsignedBigInteger('discount_amount')->after('discount_code')->nullable()->comment('Total discount applied to the order');
            $table->unsignedBigInteger('total_product_price')->after('discount_amount')->nullable()->comment('Total product price after applying discount or not');
            $table->unsignedBigInteger('total_order_price')->after('total_product_price')->comment('Final total price including discount and shipping cost');

            $table->foreign('discount_code')->references('code')->on('discounts')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['discount_code']);

            $table->dropColumn([
                'discount_code',
                'discount_amount',
                'total_product_price',
                // 'shipping_cost',
                'total_order_price'
            ]);
        });
    }
};
