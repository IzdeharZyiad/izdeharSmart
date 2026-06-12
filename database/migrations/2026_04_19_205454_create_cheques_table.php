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
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->string('cheque_number')->unique();
            $table->string('bank_name');
            $table->decimal('amount');
            $table->date('due_date');
            $table->string('status');
            $table->string('chequeImg')->nullable();
            $table->morphs('chequeable');
            // $table->foreignId('purchase_id')->nullable()->constrained();
            // $table->foreignId('sale_id')->nullable()->constrained();
            // $table->foreignId('expense_id')->nullable()->constrained();
            $table->foreignId('admin_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
