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
    Schema::create('notificaciones', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tarea_id');
        $table->foreign('tarea_id')->references('id')->on('tareas')->onDelete('cascade');
        $table->string('mensaje');
        $table->dateTime('fecha_envio')->nullable();
        $table->enum('estado', ['pendiente', 'enviada', 'leida'])->default('pendiente');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
