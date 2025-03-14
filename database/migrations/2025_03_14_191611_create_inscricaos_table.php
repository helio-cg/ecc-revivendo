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
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_ele');
            $table->string('nome_ela');
            $table->string('nome_usual_ele');
            $table->string('nome_usual_ela');
            $table->string('telefone')->unique();
            $table->enum('status_pagamento', ['pendente', 'pago'])->default('pendente');
            $table->foreignId('paroquia_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incricaos');
    }
};
