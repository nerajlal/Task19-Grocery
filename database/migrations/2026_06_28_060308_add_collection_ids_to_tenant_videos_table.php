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
        Schema::table('tenant_videos', function (Blueprint $table) {
            $table->unsignedBigInteger('video1_collection_id')->nullable()->after('video1_url');
            $table->unsignedBigInteger('video2_collection_id')->nullable()->after('video2_url');
            $table->unsignedBigInteger('video3_collection_id')->nullable()->after('video3_url');
            $table->unsignedBigInteger('video4_collection_id')->nullable()->after('video4_url');
            $table->unsignedBigInteger('video5_collection_id')->nullable()->after('video5_url');

            $table->foreign('video1_collection_id')->references('id')->on('collections')->onDelete('set null');
            $table->foreign('video2_collection_id')->references('id')->on('collections')->onDelete('set null');
            $table->foreign('video3_collection_id')->references('id')->on('collections')->onDelete('set null');
            $table->foreign('video4_collection_id')->references('id')->on('collections')->onDelete('set null');
            $table->foreign('video5_collection_id')->references('id')->on('collections')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_videos', function (Blueprint $table) {
            $table->dropForeign(['video1_collection_id']);
            $table->dropForeign(['video2_collection_id']);
            $table->dropForeign(['video3_collection_id']);
            $table->dropForeign(['video4_collection_id']);
            $table->dropForeign(['video5_collection_id']);

            $table->dropColumn([
                'video1_collection_id',
                'video2_collection_id',
                'video3_collection_id',
                'video4_collection_id',
                'video5_collection_id',
            ]);
        });
    }
};
