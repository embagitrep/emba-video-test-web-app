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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('merchant_id')->index();
            $table->ulid('session_id');
            $table->string('app_id');
            $table->string('phone');
            $table->text('name')->nullable();
            $table->decimal('amount', 10);
            $table->string('status',60)->default('pending');
            $table->string('api_version', 10)->default('v1');
            $table->text('redirect_url')->nullable();
            $table->text('webhook_url');
            $table->text('description')->nullable();
            $table->string('lang',40)->default('az');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
