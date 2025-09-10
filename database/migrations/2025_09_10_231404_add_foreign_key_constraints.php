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
        // Add foreign key constraint for assets.location_id -> locations.id
        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });

        // Add foreign key constraint for checkouts.asset_id -> assets.id
        Schema::table('checkouts', function (Blueprint $table) {
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });

        // Add foreign key constraint for checkouts.user_id -> users.id
        Schema::table('checkouts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
        });

        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropForeign(['asset_id']);
            $table->dropForeign(['user_id']);
        });
    }
};