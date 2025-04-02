<?php

namespace App\Filament\Admin\Widgets;

use Filament\Tables;
use App\Models\Paroquia;
use App\Models\Inscricao;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class TopInscritos extends BaseWidget
{
    protected static ?string $heading = 'Top 10 Paróquias com Inscrições Completas';

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->defaultPaginationPageOption(10)
            ->striped()
            ->query(
                Paroquia::query()
                    ->select('paroquias.*') // Seleciona os campos da paróquia
                    ->withCount(['inscricao' => function (Builder $query) {
                        $query->where('status_pagamento', 'pago');
                    }]) // Conta apenas inscrições pagas
                    ->orderByDesc('inscricao_count') // Ordena pelo total de inscrições pagas
                    ->limit(10) // Limita aos 10 primeiros
            )
            ->columns([
                Tables\Columns\TextColumn::make('ranking')
                    ->label('Posição')
                    ->getStateUsing(function ($record, $rowLoop) {
                        return $rowLoop->iteration.'º'; // Numera de 1 a 10
                    })
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Paróquia')
                    ->formatStateUsing(fn ($record) => "{$record->name} - {$record->city}"),
                Tables\Columns\TextColumn::make('inscricao_count')
                    ->label('Total de Inscrições')
                    ->formatStateUsing(fn ($record) => "{$record->inscricao_count} confirmadas"),
            ])
            ->defaultSort('inscricao_count', 'desc');
    }
}
