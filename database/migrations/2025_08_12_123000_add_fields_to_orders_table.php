<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('city')->nullable()->after('phone');
            $table->text('address')->nullable()->after('city');
            $table->decimal('salary', 12, 2)->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['city', 'address', 'salary']);
        });
    }
};







