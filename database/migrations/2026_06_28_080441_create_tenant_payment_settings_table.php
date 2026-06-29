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
        Schema::create('tenant_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->boolean('cod_enabled')->default(true);
            $table->boolean('stripe_enabled')->default(false);
            $table->string('stripe_key')->nullable();
            $table->string('stripe_secret')->nullable();
            $table->boolean('razorpay_enabled')->default(false);
            $table->string('razorpay_key')->nullable();
            $table->string('razorpay_secret')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_payment_settings');
    }
};
