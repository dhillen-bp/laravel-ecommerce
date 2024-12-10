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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->after('transaction_id');
            $table->timestamp('transaction_time')->nullable()->after('payment_type');
            $table->string('bank')->nullable()->after('transaction_time');
            $table->unsignedBigInteger('gross_amount')->nullable()->after('bank');
            $table->string('midtrans_status')->nullable()->after('gross_amount');

            $table->dropColumn(['payment_proof']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_proof');

            $table->dropColumn(['payment_type', 'transaction_time', 'bank', 'gross_amount', 'midtrans_status']);
        });
    }
};
