<?php

namespace App\Filament\Admin\Resources\Inscritos\Pages;

use App\Filament\Admin\Resources\Inscritos\InscritoResource;
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
