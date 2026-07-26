<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'transactionID' => fake()->optional(0.8)->unique()->uuid(),
            'invoiceable_id' => null,
            'invoiceable_type' => null,
            'valor' => fake()->randomFloat(2, 80, 250),
            'status' => fake()->randomElement(['pendente', 'Pago', 'Cortesia', 'Cancelado']),
            'paymentDate' => fake()->optional(0.7)->dateTimeBetween('-6 months', 'now'),
            'invoiceUrl' => fake()->optional(0.5)->url(),
            'forma_de_pagamento' => fake()->optional(0.6)->randomElement(['Pix', 'Boleto', 'Cartão', 'Manual ou Cartão']),
        ];
    }
}
