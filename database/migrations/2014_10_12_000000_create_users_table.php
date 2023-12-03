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
            $table->string('nickname', 255)->unique()->nullable();
            $table->string('name', 255);
            $table->string('surnames', 255);
            $table->string('password', 255)->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->bigInteger('country_id')->nullable()->unsigned();
            $table->string('profile_img')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('rol_id')->unsigned()->default(3)->nullable();
            $table->integer('strikes')->unsigned()->default(0)->nullable();
            $table->boolean('blocked')->default(false)->nullable();
            $table->boolean('deleted')->default(false);
            $table->string('biography')->nullable();
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
