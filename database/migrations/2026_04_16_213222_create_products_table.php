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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            /* $table->decimal('Quantity', 10, 2)->default('0');
             $table->decimal('lessQuantity', 10, 2)->default('0');
             $table->decimal('price', 10, 2)->default('0');
             $table->decimal('avgPrice', 10, 2)->default('0');*/
            $table->string('productImg')->nullable();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('admin_id')->constrained();

            $table->unique(['name', 'item_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
