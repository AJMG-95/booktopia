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
        Schema::create('edition_invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('edition_id')->unsigned();
            $table->bigInteger('invoice_id')->unsigned();
            $table->timestamps();

            $table->foreign('edition_id')->references('id')->on('editions')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edition_invoices');
    }
};
