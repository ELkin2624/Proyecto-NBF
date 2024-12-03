<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    Public function up()

    {
        Schema::table('producto', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario')->nullable(); // Añadir la columna
            $table->foreign('id_usuario')->references('id')->on('usuario'); // Relación con la tabla users
        });
        
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id('id_bitacora');
            $table->string('accion');
            $table->string('ip_usuario');
            $table->date('fecha');
            $table->time('hora');
            $table->string('detalles')->nullable();
            $table->string('tabla_asociada')->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade'); // Suponiendo que tienes una tabla de usuarios
            $table->timestamps();
        });
        if (!Schema::hasColumn('bitacora', 'id_usuario')) {
            Schema::table('bitacora', function (Blueprint $table) {
                $table->unsignedBigInteger('id_usuario')->nullable();
                $table->foreign('id_usuario')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_');
    }
};
