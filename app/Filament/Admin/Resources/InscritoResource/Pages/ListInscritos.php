<?php

namespace App\Filament\Admin\Resources\InscritoResource\Pages;

use Filament\Actions;
use App\Models\Paroquia;
use App\Models\Inscricao;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\HasTableInscricaoTab;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Admin\Resources\InscritoResource;

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

                    CheckboxList::make('status_pagamento')
                        ->label('Status')
                        ->options([
                            'Pago' => 'Pago',
                            'Cortesia' => 'Cortesia',
                            'Pendente' => 'Pendente',
                        ])
                        ->required(),
                ])
                ->action(fn (array $data) => static::gerarPdf($data['paroquia_id'], $data['status_pagamento'])),
        ];
    }

    public static function gerarPdf($paroquiaId, $status)
    {
        $tamanhos = ['PP', 'P', 'M', 'G', 'GG', 'EXG', 'EXGG'];
        $resultado = [];
        $total=0;

        foreach ($tamanhos as $tamanho) {
            $quantidade = Inscricao::where('paroquia_id', $paroquiaId)
                //->whereIn('status_pagamento', ['Pago', 'Cortesia'])
                ->whereIn('status_pagamento', (array) $status)
                ->where('tamanho_camisa_ela', $tamanho)
               /* ->where(function ($query) use ($tamanho) {
                    $query->where('tamanho_camisa_ele', $tamanho)
                        ->orWhere('tamanho_camisa_ela', $tamanho);
                })*/
                ->count();

            $resultado[$tamanho] = $quantidade;
            $total += $quantidade;
        }

        foreach ($tamanhos as $tamanho) {
            $quantidade = Inscricao::where('paroquia_id', $paroquiaId)
                //->whereIn('status_pagamento', ['Pago', 'Cortesia'])
                ->whereIn('status_pagamento', (array) $status)
                ->where('tamanho_camisa_ele', $tamanho)
               /* ->where(function ($query) use ($tamanho) {
                    $query->where('tamanho_camisa_ele', $tamanho)
                        ->orWhere('tamanho_camisa_ela', $tamanho);
                })*/
                ->count();

            // Adiciona ao valor já existente
            if (isset($resultado[$tamanho])) {
                $resultado[$tamanho] += $quantidade;
            } else {
                $resultado[$tamanho] = $quantidade;
            }
            $total += $quantidade;
        }

        $inscricoes = Inscricao::where('paroquia_id', $paroquiaId)
            //->where('status_pagamento', $status)
            ->whereIn('status_pagamento', (array) $status)
            ->get();

        $paroquia = Paroquia::firstWhere('id', $paroquiaId);

        $pdf = Pdf::loadView('pdf.inscricoes', compact('inscricoes','paroquia','resultado','total'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "inscricoes_{$paroquia->name}_{$paroquia->city}.pdf"
        );
    }
}
