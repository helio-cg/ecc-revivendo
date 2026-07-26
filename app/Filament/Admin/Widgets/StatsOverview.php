<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Inscricao;
use App\Models\InscricaoIndividual;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalInscritos = Inscricao::count();
        $totalConfirmadas = Inscricao::whereIn('status_pagamento', ['Pago', 'Cortesia'])->count();
        $totalInscritosPendente = Inscricao::where('status_pagamento', 'Pendente')->count();
        $totalCortesiaCasais = Inscricao::where('status_pagamento', 'Cortesia')->count();
        $totalCortesiaIndividual = InscricaoIndividual::where('status_pagamento', 'Cortesia')->count();
        $totalCortesia = $totalCortesiaCasais + $totalCortesiaIndividual;

        return [
            Stat::make('Inscrições', $totalInscritos . ' inscritos')
                ->description('Total de casais cadastrados')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Confirmadas', $totalConfirmadas . ' inscritos')
                ->description('Pago + Cortesia')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Pendente', $totalInscritosPendente . ' inscritos')
                ->description('Aguardando pagamento')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make('Cortesias', $totalCortesia . ' inscritos')
                ->description("Casais: {$totalCortesiaCasais} | Individual: {$totalCortesiaIndividual}")
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
        ];
    }
}
