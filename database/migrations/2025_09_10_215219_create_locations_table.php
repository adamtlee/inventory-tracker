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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_id')->unique(); // Unique ID for each location
            $table->string('location'); // e.g., "Main Tool Room," "Maintenance Shed"
            $table->string('bin')->nullable(); // Specific bin or shelf within the location
            $table->text('description')->nullable(); // Additional location details
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
