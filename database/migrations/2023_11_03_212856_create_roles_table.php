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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('rol_name');
            $table->timestamps();

            $table->insert([
                ['rol_name' => 'admin', 'id' => 1],
                ['rol_name' => 'sub_admin', 'id' => 2],
                ['rol_name' => 'user', 'id' => 3],
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
