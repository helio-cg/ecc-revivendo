<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Inscricao;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class StatsInscritos extends ChartWidget
{
    protected static ?string $heading = 'Inscrições nos últimos 30 dias';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $data = Trend::query(Inscricao::query())
            //->dateColumn('paymentDate')
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->count();
        $data2 = Trend::query(Inscricao::where('status_pagamento','pago'))
            ->dateColumn('paymentDate')
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->count();
        return [
            'datasets' => [
                [

                    'label' => 'Inscrições realizadas',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#0C2A61FF',
                    'backgroundColor' => '#1C5AB8FF',
                ],
                [
                    'label' => 'Inscrições confirmadas',
                    'data' => $data2->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#4D7941',
                    'backgroundColor' => '#7CA772',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
