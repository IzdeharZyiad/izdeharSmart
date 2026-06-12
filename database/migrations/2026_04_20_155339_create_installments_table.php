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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('purchase_id')->nullable()->constrained();
            // $table->foreignId('sale_id')->nullable()->constrained();
            $table->morphs('installmentable');
            $table->decimal('firstPay', 10, 2)->default('0');
            $table->decimal('finalMount', 10, 2)->default('0');
            $table->integer('installmentsCount')->default(0);
            $table->decimal('installmentAmount', 10, 2)->default('0');
            $table->integer('intervalDays')->default(0);
            $table->date('dateDay');
            $table->string('status');
            $table->foreignId('admin_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
