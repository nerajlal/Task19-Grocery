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
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number')->unique();
            $table->string('status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            $table->string('payment_method')->default('cod');
            $table->string('payment_status')->default('pending'); // pending, paid, failed, refunded
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);
            
            // Customer Details Snapshot
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            
            // Address Snapshot (JSON is flexible)
            $table->json('shipping_address'); 
            $table->json('billing_address')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamp('placed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('bundle_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('name'); // Store name in case product changes
            $table->string('sku')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Unit price at time of purchase
            $table->decimal('total', 10, 2); // quantity * price
            $table->string('size')->nullable();
            $table->string('type')->default('product'); // product or bundle
            
            $table->json('options')->nullable(); // For any other variant info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
