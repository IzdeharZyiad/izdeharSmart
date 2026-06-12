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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('dateDay');
            $table->string('dayName');
            $table->foreignId('purchase_id')->nullable()->constrained();
            $table->foreignId('sale_id')->nullable()->constrained();
            $table->decimal('amount', 10, 2)->default('0');
            $table->string('payment_methode');
            $table->string('type');
            $table->string('refrece_id')->nullable();
            $table->foreignId('admin_id')->constrained();
            $table->timestamps();
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
