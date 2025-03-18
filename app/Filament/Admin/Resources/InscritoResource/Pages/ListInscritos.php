<?php

namespace App\Filament\Admin\Resources\InscritoResource\Pages;

use Filament\Actions;
use App\Models\Paroquia;
use App\Models\Inscricao;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\InscritoResource;
use App\Traits\HasTableInscricaoTab;

class ListInscritos extends ListRecords
{
    protected static string $resource = InscritoResource::class;

    use HasTableInscricaoTab;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
            Action::make('Gerar PDF')
                ->label('Gerar PDF')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->form([
                    Select::make('paroquia_id')
                        ->label('Paróquia')
                        ->relationship('paroquia', 'name')
                        ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} - {$record->city}")
                        ->searchable(['name', 'city'])
                        ->preload()
                        ->native(false)
                        ->required(),

                    Select::make('status_pagamento')
                        ->label('Status')
                        ->options([
                            'Pago' => 'Pago',
                            'Pendente' => 'Pendente',
                        ])
                        ->required(),
                ])
                ->action(fn (array $data) => static::gerarPdf($data['paroquia_id'], $data['status_pagamento'])),
        ];
    }

    public static function gerarPdf($paroquiaId, $status)
    {
        $inscricoes = Inscricao::where('paroquia_id', $paroquiaId)
            ->where('status_pagamento', $status)
            ->get();

        $paroquia = Paroquia::firstWhere('id', $paroquiaId);

        $pdf = Pdf::loadView('pdf.inscricoes', compact('inscricoes','paroquia'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "inscricoes_{$paroquia->name}_{$paroquia->city}.pdf"
        );
    }
}
