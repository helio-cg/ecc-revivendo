<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\InscricaoIndividual;
use App\Models\Paroquia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InscricaoIndividual>
 */
class InscricaoIndividualFactory extends Factory
{
    protected $model = InscricaoIndividual::class;

    public function definition(): array
    {
        $tamanhos = ['PP', 'P', 'M', 'G', 'GG', 'XG', 'EXG', 'EXGG'];

        return [
            'nome' => fake()->name(),
            'nome_usual' => fake()->firstName(),
            'tamanho_camisa' => fake()->randomElement($tamanhos),
            'telefone' => fake()->unique()->numerify('###########'),
            'paroquia_id' => Paroquia::inRandomOrder()->first()?->id ?? Paroquia::factory(),
            'status_pagamento' => fake()->randomElement(array_column(InvoiceStatus::cases(), 'value')),
            'paymentDate' => fake()->optional(0.7)->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
