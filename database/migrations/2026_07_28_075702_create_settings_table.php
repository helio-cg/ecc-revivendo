<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->date('data_limite')->nullable();
            $table->boolean('inscricoes_liberadas')->default(false); // este campo só é valido após a data limite, caso contrário, o sistema permite inscrições. False antes do limte, liberado, false sepois do limite bloqueado e true depois do limite lierado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
