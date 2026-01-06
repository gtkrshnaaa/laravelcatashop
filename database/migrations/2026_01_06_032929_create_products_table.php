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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 15, 0)->default(0); // No decimal for IDR
            $table->integer('stock')->default(0);
            $table->boolean('stock_control')->default(true);
            $table->json('images')->nullable(); // Array of image paths
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for SEO and filtering
            $table->index('slug');
            $table->index('sku');
            $table->index('is_active');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
