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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->bigInteger('edition_id')->unsigned();
            $table->bigInteger('edition_name')->unsigned();
            $table->unsignedTinyInteger('quantity')->default(1); // Maximum value of 1
            $table->string('amount');
            $table->string('currency');
            $table->bigInteger('user_id')->unsigned();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('payment_status');
            $table->string('payment_method');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('edition_id')->references('id')->on('editions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
