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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->nullable();
            $table->string('name', 255);
            $table->string('surnames', 255)->nullable();
            $table->date('birth_at')->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->string('biography', 1000)->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
