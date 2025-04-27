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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('placa')->unique(); // placa, única
            $table->unsignedBigInteger('cliente_id'); // cliente_id como unsigned
            $table->timestamps();

            // Definir la clave foránea
            $table->foreign('cliente_id')
                  ->references('id')->on('clientes')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
