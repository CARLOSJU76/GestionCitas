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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('telefono', 20);
            $table->string('identificacion', 20)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('perfil_id')->nullable();
            $table->timestamps();

            // Definir la clave foránea hacia la tabla perfiles
            $table->foreign('perfil_id')->references('id')->on('perfiles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
