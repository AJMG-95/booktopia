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
        Schema::create('editions', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->nullable();
            $table->string('title');
            $table->string('description');
            $table->string('cover')->nullable();
            $table->string('editorial')->nullable();
            $table->date('publication_date')->nullable();
            $table->decimal('price', 8, 2)->unsigned();
            $table->string('url')->nullable();
            $table->bigInteger('book_id')->unsigned();
            $table->bigInteger('language_id')->unsigned();
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editions');
    }
};
