<?php

use App\Enums\InvoiceStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('tamanho_camisa_ele');
            $table->string('tamanho_camisa_ela');
            $table->string('telefone')->unique();
            $table->date('paymentDate')->nullable();
            $table->enum('status_pagamento', array_column(InvoiceStatus::cases(),'value'))->default('Pendente');
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
