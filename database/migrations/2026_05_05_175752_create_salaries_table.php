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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('dayName');
            $table->decimal('mount', 10, 2)->default('0');
            $table->decimal('advanceSum', 10, 2)->default('0');
            $table->decimal('salaryMount', 10, 2)->default('0');
            $table->integer('DayAttendance')->default('0');
            $table->date('startDate');
            $table->date('endDate');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('salary_cycle_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
