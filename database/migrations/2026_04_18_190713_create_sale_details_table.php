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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('product_detail_id')->constrained();
            $table->decimal('quantity', 10, 2)->default('0');
            $table->decimal('sale_price', 10, 2)->default('0');
            $table->string('typeDisCount')->nullable();
            $table->decimal('disCount', 10, 2)->default('0');
            $table->decimal('subtotal', 10, 2)->default('0'); // اذا اشتريت اكتر من منتج
            $table->decimal('profit', 10, 2)->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
