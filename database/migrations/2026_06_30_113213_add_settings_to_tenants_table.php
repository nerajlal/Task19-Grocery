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
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('about_title')->default('Cultivating Health & Happiness')->after('theme');
            $table->text('about_text')->nullable()->after('about_title');
            $table->string('contact_email')->nullable()->after('about_text');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->text('contact_address')->nullable()->after('contact_phone');
            $table->text('shipping_policy')->nullable()->after('contact_address');
            $table->text('return_policy')->nullable()->after('shipping_policy');
            $table->text('terms_of_service')->nullable()->after('return_policy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'about_title',
                'about_text',
                'contact_email',
                'contact_phone',
                'contact_address',
                'shipping_policy',
                'return_policy',
                'terms_of_service'
            ]);
        });
    }
};
