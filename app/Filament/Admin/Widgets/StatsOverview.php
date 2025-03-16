<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Inscricao;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalInscritos = Inscricao::count();
        $totalInscritosPago = Inscricao::where('status_pagamento', 'pago')->count();
        $totalInscritosPendente = Inscricao::where('status_pagamento', 'pendente')->count();

        return [
            Stat::make('Inscrições', $totalInscritos . ' inscritos')
                ->description('Total de casais cadastrados')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Confirmadas', $totalInscritosPago . ' inscritos')
                ->description('Pagamentos confirmados')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Pendente', $totalInscritosPendente . ' inscritos')
                ->description('Aguardando pagamento')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
        ];
    }
}
