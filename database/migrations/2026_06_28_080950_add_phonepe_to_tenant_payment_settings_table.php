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
        Schema::table('tenant_payment_settings', function (Blueprint $table) {
            $table->boolean('phonepe_enabled')->default(false)->after('razorpay_secret');
            $table->string('phonepe_merchant_id')->nullable()->after('phonepe_enabled');
            $table->string('phonepe_salt_key')->nullable()->after('phonepe_merchant_id');
            $table->string('phonepe_salt_index')->nullable()->after('phonepe_salt_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_payment_settings', function (Blueprint $table) {
            $table->dropColumn([
                'phonepe_enabled',
                'phonepe_merchant_id',
                'phonepe_salt_key',
                'phonepe_salt_index',
            ]);
        });
    }
};
