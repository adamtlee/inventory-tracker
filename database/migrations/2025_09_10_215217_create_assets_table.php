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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id')->unique(); // e.g., TOOL-001, Shovel-A
            $table->string('item'); // e.g., Shovel, Power Drill, Ladder
            $table->string('item_code')->unique(); // Human-readable identifier
            $table->string('belongs_to'); // Department or team
            $table->enum('condition', ['Excellent', 'Good', 'Fair', 'Worn', 'Damaged', 'Out of Service']);
            $table->text('comments')->nullable(); // Permanent notes
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
