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
        Schema::create('sale_product_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('purchase_id')->constrained();
            $table->decimal('quantity', 10, 2)->default('0');
            $table->foreignId('admin_id')->constrained();
            $table->decimal('price_purchase', 10, 2)->default('0'); // سعر القطعه الواحده
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_product_batches');
    }
};
