<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

trait HasTableInscricaoTab {

    public function getTabs(): array
    {
        $model = static::getModel()::query();
        $total = $model->count();

        return [
            'todos' => Tab::make()
                ->icon('heroicon-o-bars-4')
                ->badge($total),
            'pago' => Tab::make()
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pagamento','Pago')),
            'pendente' => Tab::make()
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pagamento','Pendente')),
        ];
    }
}