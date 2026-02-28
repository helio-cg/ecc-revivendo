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

            $table->string('transactionID')->unique()->nullable();

            // relação polimórfica
            $table->morphs('invoiceable');
            // cria:
            // invoiceable_id
            // invoiceable_type

            $table->decimal('valor', 10, 2);
            $table->string('status')->default('pendente');

            $table->date('paymentDate')->nullable();
            $table->string('invoiceUrl')->nullable();

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
