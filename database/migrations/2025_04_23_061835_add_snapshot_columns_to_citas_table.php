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
        Schema::table('citas', function (Blueprint $table) {
            Schema::table('citas', function (Blueprint $table) {
                $table->string('cliente_nombre')->nullable();
                $table->string('servicio_nombre')->nullable();
                $table->string('estado_nombre')->nullable();
                $table->dateTime('fecha_hora')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn(['cliente_nombre', 'servicio_nombre', 'estado_nombre', 'fecha_hora']);
        });
    }
};
