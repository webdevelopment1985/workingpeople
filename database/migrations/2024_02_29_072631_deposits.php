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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('referrence_id');
            $table->string('transaction_id');
            $table->string('amount');
            $table->string('original_amount');
            $table->double('fee', 8, 2);
            $table->double('conversion_rate', 8, 2);
            $table->double('value', 8, 2);
            $table->enum('deposit_method',['USDT','SRI'])->default('crypto');;
            $table->enum('deposit_type',['crypto'])->default('crypto');;
            $table->string('remarks')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('is_sent');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('deposits');
    }
};
