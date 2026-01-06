<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('courier_name')->nullable()->after('payment_method');
            $table->string('tracking_number')->nullable()->after('courier_name');
            $table->date('estimated_delivery')->nullable()->after('tracking_number');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['courier_name', 'tracking_number', 'estimated_delivery']);
        });
    }
};
