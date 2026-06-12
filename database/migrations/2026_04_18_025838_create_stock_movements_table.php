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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_detail_id')->constrained();
            $table->enum('type', ['شراء', 'بيع', 'يدوي']);
            $table->decimal('quantity', 10, 2);
            $table->decimal('before_quantity', 10, 2);
            $table->decimal('after_quantity', 10, 2);
            $table->foreignId('purchase_detail_id')->nullable()->constrained();
            $table->foreignId('sale_detail_id')->nullable()->constrained();
            $table->foreignId('admin_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
