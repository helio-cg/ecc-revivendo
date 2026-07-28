<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Inscricao;
use App\Models\InscricaoIndividual;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ParoquiaSeeder::class,
            SettingsSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'password'
        ]);

        Inscricao::factory(500)->create();

        InscricaoIndividual::factory()->create([
            'nome' => 'Maria Silva',
            'nome_usual' => 'Maria',
        ]);
    }
}
