<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('dateDay');
            $table->string('dayName');
            $table->decimal('totalPrice', 10, 2)->default('0');
            $table->decimal('totalProfit', 10, 2)->default('0');
            $table->string('payment_type')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('admin_id')->constrained();
            $table->foreignId('custemer_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
