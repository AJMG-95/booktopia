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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname', 30);
            $table->string('name', 50);
            $table->string('surnames', 50);
            $table->string('password', 255);
            $table->date('birth_date');
            $table->bigInteger('country_id')->nullable()->unsigned();
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('rol_id')->unsigned()->default(3);
            $table->boolean('blocked')->default(false);
            $table->integer('strikes')->unsigned()->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
