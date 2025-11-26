<?php

namespace App\Filament\Admin\Resources\InscritoIndividuals\Pages;

use App\Filament\Admin\Resources\InscritoIndividuals\InscritoIndividualResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInscritoIndividual extends EditRecord
{
    protected static string $resource = InscritoIndividualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
