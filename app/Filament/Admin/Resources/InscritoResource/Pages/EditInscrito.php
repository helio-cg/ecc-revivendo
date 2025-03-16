<?php

namespace App\Filament\Admin\Resources\InscritoResource\Pages;

use App\Filament\Admin\Resources\InscritoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInscrito extends EditRecord
{
    protected static string $resource = InscritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
