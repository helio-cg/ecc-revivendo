<?php

namespace Database\Factories;

use App\Models\Paroquia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paroquia>
 */
class ParoquiaFactory extends Factory
{
    protected $model = Paroquia::class;

    public function definition(): array
    {
        return [
            'name' => 'Paroquia ' . fake()->unique()->citySuffix() . ' ' . fake()->lastName(),
            'city' => fake()->unique()->city(),
        ];
    }
}
