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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete(); // Preserve history
            $table->json('product_snapshot'); // name, sku at checkout time
            $table->integer('quantity');
            $table->decimal('price_locked', 15, 0); // Price when checkout button clicked
            $table->decimal('subtotal', 15, 0); // quantity * price_locked
            $table->timestamps();

            // Indexes for queries
            $table->index('transaction_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
