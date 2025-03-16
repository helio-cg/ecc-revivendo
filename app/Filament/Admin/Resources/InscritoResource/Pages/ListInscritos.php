<?php

namespace App\Filament\Admin\Resources\InscritoResource\Pages;

use App\Filament\Admin\Resources\InscritoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInscritos extends ListRecords
{
    protected static string $resource = InscritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
