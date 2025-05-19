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
        Schema::table('rutas', function (Blueprint $table) {
            if (Schema::hasColumn('rutas', 'presupuesto_ruta')) {
                $table->dropColumn('presupuesto_ruta');
            }
            if (Schema::hasColumn('rutas', 'ciudades_ruta')) {
                $table->dropColumn('ciudades_ruta');
            }
            if (Schema::hasColumn('rutas', 'duracion_ruta')) {
                $table->dropColumn('duracion_ruta');
            }
            if (Schema::hasColumn('rutas', 'tematica_ruta')) {
                $table->dropColumn('tematica_ruta');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rutas', function (Blueprint $table) {
            //
        });
    }
};
