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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del negocio
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('logo_path')->nullable(); // Ruta del logo (almacenado en disco)
            $table->string('currency', 10)->default('BOB'); // Moneda (BOB, USD, etc.)
            $table->string('timezone')->default('America/La_Paz'); // Zona horaria
            $table->json('settings')->nullable(); // Config extra como impuestos, colores, etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
