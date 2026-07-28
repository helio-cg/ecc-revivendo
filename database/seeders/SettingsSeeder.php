<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Settings::firstOrCreate([], [
            'data_limite' => null,
            'inscricoes_liberadas' => true,
        ]);
    }
}
