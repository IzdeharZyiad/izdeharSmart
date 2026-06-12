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
        Schema::table('sale_product_batches', function (Blueprint $table) {
            $table->foreignId('sale_detail_id')
              ->nullable()
              ->constrained('sale_details')
              ->nullOnDelete()
              ->after('sale_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_product_batches', function (Blueprint $table) {
            $table->dropForeign(['sale_detail_id']);
            $table->dropColumn('sale_detail_id');
        });
    }
};
