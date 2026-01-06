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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->json('customer_info'); // Snapshot: name, whatsapp, address
            $table->enum('payment_method', ['bank_transfer', 'cod'])->default('bank_transfer');
            $table->integer('unique_code'); // 3 digit (100-999)
            $table->decimal('amount_subtotal', 15, 0)->default(0);
            $table->decimal('amount_total', 15, 0)->default(0); // subtotal + unique_code
            $table->enum('status', ['unpaid', 'paid', 'shipped', 'completed', 'cancelled'])->default('unpaid');
            $table->json('status_history')->nullable(); // Audit trail
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Indexes for searching and filtering
            $table->index('invoice_code');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
