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
            if (Schema::hasColumn('citas', 'cliente_nombre')) {
                $table->dropColumn('cliente_nombre');
            }
            if (Schema::hasColumn('citas', 'servicio_nombre')) {
                $table->dropColumn('servicio_nombre');
            }
            if (Schema::hasColumn('citas', 'estado_nombre')) {
                $table->dropColumn('estado_nombre');
            }
            if (Schema::hasColumn('citas', 'fecha_hora')) {
                $table->dropColumn('fecha_hora');
            }
        });
    }

   
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->string('cliente_nombre')->nullable();
            $table->string('servicio_nombre')->nullable();
            $table->string('estado_nombre')->nullable();
            $table->dateTime('fecha_hora')->nullable();
        });
    }
};
