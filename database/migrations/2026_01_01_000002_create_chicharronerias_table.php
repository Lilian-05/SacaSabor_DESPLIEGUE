<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chicharronerias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propietario_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('direccion')->nullable();
            $table->string('zona')->nullable();
            $table->string('referencia')->nullable();
            $table->string('telefono')->nullable();
            $table->string('foto')->nullable();
            $table->string('foto_portada')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->boolean('destacado')->default(false);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chicharronerias');
    }
};
