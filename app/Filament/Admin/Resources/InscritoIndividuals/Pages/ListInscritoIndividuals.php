<?php

namespace App\Filament\Admin\Resources\InscritoIndividuals\Pages;

use Filament\Actions;
use App\Models\Paroquia;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Admin\Resources\InscritoIndividuals\InscritoIndividualResource;
use App\Models\InscricaoIndividual;

class ListInscritoIndividuals extends ListRecords
{
    protected static string $resource = InscritoIndividualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
             Action::make('Total Geral Individual')
                ->label('Total Geral Individual')
                ->icon('heroicon-o-document-text')
                ->color('primary')
                ->action(fn (array $data) => static::gerarPdfGeralIndividuais()),
            Action::make('Gerar PDF')
                ->label('Gerar PDF')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->schema([
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
            $quantidade = InscricaoIndividual::where('paroquia_id', $paroquiaId)
                //->whereIn('status_pagamento', ['Pago', 'Cortesia'])
                ->whereIn('status_pagamento', (array) $status)
                ->where('tamanho_camisa', $tamanho)
               /* ->where(function ($query) use ($tamanho) {
                    $query->where('tamanho_camisa_ele', $tamanho)
                        ->orWhere('tamanho_camisa_ela', $tamanho);
                })*/
                ->count();

            // Adiciona ao valor já existente
          /*  if (isset($resultado[$tamanho])) {
                $resultado[$tamanho] += $quantidade;
            } else {
                $resultado[$tamanho] = $quantidade;
            }*/
            $total += $quantidade;
        }

        $inscricoes = InscricaoIndividual::where('paroquia_id', $paroquiaId)
            //->where('status_pagamento', $status)
            ->whereIn('status_pagamento', (array) $status)
            ->get();

        $paroquia = Paroquia::firstWhere('id', $paroquiaId);

        $pdf = Pdf::loadView('pdf.inscricoes-individuais', compact('inscricoes','paroquia','resultado','total'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "inscricoes_individuais_{$paroquia->name}_{$paroquia->city}.pdf"
        );
    }

    public static function gerarPdfGeralIndividuais()
    {
        $tamanhos = ['PP', 'P', 'M', 'G', 'GG', 'EXG', 'EXGG'];
        $paroquias = Paroquia::all();

        $tabela = [];
        $totalGeral = array_fill_keys($tamanhos, 0);
        $totalGeral['total'] = 0;

        foreach ($paroquias as $paroquia) {
            $resultado = [];
            $total = 0;

            foreach ($tamanhos as $tamanho) {
                $quantidade = InscricaoIndividual::where('paroquia_id', $paroquia->id)
                   // ->whereIn('status_pagamento', (array)$status)
                    ->where('tamanho_camisa', $tamanho)
                    ->count();

                $resultado[$tamanho] = $quantidade;
                $total += $quantidade;

                // Acumula total geral
                $totalGeral[$tamanho] += $quantidade;
            }

            $resultado['total'] = $total;
            $totalGeral['total'] += $total;

            $tabela[] = [
                'paroquia' => $paroquia->name,
                'cidade' => $paroquia->city,
                'dados' => $resultado,
            ];
        }

        // Geração do PDF
        $pdf = Pdf::loadView('pdf.inscricoes-individuais-geral', [
            'tabela' => $tabela,
            'totalGeral' => $totalGeral,
            'tamanhos' => $tamanhos,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "inscricoes_individuais_geral.pdf"
        );
    }

}
