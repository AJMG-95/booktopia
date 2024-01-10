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
        Schema::create('edition_books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->nullable();
            $table->boolean('self_published')->default(false);
            $table->string('title', 255)->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->boolean('visible')->default(true);
            $table->string('editorial')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('document')->nullable();
            $table->bigInteger('language_id')->unsigned()->nullable();
            $table->boolean('for_adults')->default(false);
            $table->boolean('deleted')->default(false);
            $table->timestamps();

            $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edition_books');
    }
};
