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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Un nombre o número para el salón, ej: "Salón 201"
            $table->integer('capacity'); // La capacidad de estudiantes
            $table->string('location'); // Ej: "Edificio A, Piso 2"
            $table->text('resources')->nullable(); // Ej: "Proyector, Pizarra digital, 15 computadoras"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
