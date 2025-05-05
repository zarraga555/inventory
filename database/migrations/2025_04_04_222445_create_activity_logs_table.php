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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Quién hizo la acción
            $table->string('action'); // 'created', 'updated', 'deleted', etc.
        
            $table->string('model_type'); // Por ejemplo: App\Models\Product
            $table->unsignedBigInteger('model_id'); // ID del modelo afectado
        
            $table->json('changes')->nullable(); // Datos nuevos o modificados
            $table->ipAddress('ip')->nullable();
            $table->text('description')->nullable(); // Un texto libre con contexto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
