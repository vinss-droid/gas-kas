<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')->onDelete('cascade');
            $table->foreignId('payment_method_id')
                ->constrained('payment_methods')->onDelete('cascade');
            $table->string('month');
            $table->integer('week');
            $table->integer('year');
            $table->bigInteger('amount');
            $table->dateTime('paid_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
