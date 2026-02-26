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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // relação polimórfica
            $table->morphs('invoiceable');
            // cria:
            // invoiceable_id
            // invoiceable_type

            $table->decimal('valor', 10, 2);
            $table->string('status')->default('pendente');

            $table->string('gateway')->nullable();
            $table->string('external_id')->nullable();

            // dados PIX
            $table->text('pix_qrcode')->nullable();
            $table->text('pix_copia_cola')->nullable();
            $table->timestamp('pix_expira_em')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
