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
        $tables = [
            'users',
            'products', 
            'orders', 
            'collections', 
            'bundles', 
            'carts', 
            'attributes', 
            'sliders', 
            'home_products', 
            'discounts', 
            'articles', 
            'reviews', 
            'delivery_partners'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('tenant_id')->nullable()->after('id');
                    $table->index('tenant_id');
                    // $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade'); // Optional: strict FK
                });
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'users',
            'products', 
            'orders', 
            'collections', 
            'bundles', 
            'carts', 
            'attributes', 
            'sliders', 
            'home_products', 
            'discounts', 
            'articles', 
            'reviews', 
            'delivery_partners'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
