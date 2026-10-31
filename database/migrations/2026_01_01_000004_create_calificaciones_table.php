<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('chicharroneria_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('puntaje'); // 1 a 5
            $table->timestamps();

            $table->unique(['usuario_id', 'chicharroneria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
