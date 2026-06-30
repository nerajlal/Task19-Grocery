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
        Schema::create('customer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('tenant_id')->default(1);
            $table->timestamps();
        });

        Schema::create('customer_group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_group_id')->constrained('customer_groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('group_custom_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_group_id')->constrained('customer_groups')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('tenant_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_custom_prices');
        Schema::dropIfExists('customer_group_user');
        Schema::dropIfExists('customer_groups');
    }
};
