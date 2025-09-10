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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('checkout_id')->unique(); // Unique ID for each transaction
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('date_checked_out');
            $table->string('checked_out_by'); // Person who took the item
            $table->timestamp('date_returned')->nullable(); // Empty if still out
            $table->integer('quantity')->default(1); // Usually 1 for specific assets
            $table->text('checkout_comments')->nullable(); // Notes for this transaction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
