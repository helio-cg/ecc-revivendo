<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\Inscricao;
use App\Models\Paroquia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inscricao>
 */
class InscricaoFactory extends Factory
{
    protected $model = Inscricao::class;

    public function definition(): array
    {
        $tamanhos = ['PP', 'P', 'M', 'G', 'GG', 'XG', 'EXG', 'EXGG'];

        return [
            'nome_ele' => fake()->name('male'),
            'nome_ela' => fake()->name('female'),
            'nome_usual_ele' => fake()->firstName('male'),
            'nome_usual_ela' => fake()->firstName('female'),
            'tamanho_camisa_ele' => fake()->randomElement($tamanhos),
            'tamanho_camisa_ela' => fake()->randomElement($tamanhos),
            'telefone' => fake()->unique()->numerify('###########'),
            'paroquia_id' => Paroquia::inRandomOrder()->first()?->id ?? Paroquia::factory(),
            'status_pagamento' => fake()->randomElement(array_column(InvoiceStatus::cases(), 'value')),
            'paymentDate' => fake()->optional(0.7)->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
