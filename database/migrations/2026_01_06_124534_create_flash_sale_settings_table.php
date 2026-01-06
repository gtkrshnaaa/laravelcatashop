<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flash_sale_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('title')->default('Weekly Special Offer');
            $table->string('badge_text')->default('Flash Sale Ends Soon');
            $table->text('description')->default('Don\'t miss out on our limited time deals. Prices reset every Monday!');
            $table->integer('weekly_limit')->default(50);
            $table->string('reset_day')->default('monday');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sale_settings');
    }
};
