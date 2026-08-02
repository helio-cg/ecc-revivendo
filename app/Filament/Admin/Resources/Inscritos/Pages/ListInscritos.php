<?php

namespace App\Filament\Admin\Resources\Inscritos\Pages;

use Filament\Actions\CreateAction;
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
use App\Filament\Admin\Resources\Inscritos\InscritoResource;

class ListInscritos extends ListRecords
{
    protected static string $resource = InscritoResource::class;

    use HasTableInscricaoTab;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nova Inscrição')
                ->icon('heroicon-o-plus')
                ->color('danger'),
            Action::make('Total Geral Casais')
                ->label('Total Geral Casais')
                ->icon('heroicon-o-document-text')
                ->color('primary')
                ->action(fn (array $data) => static::gerarPdfGeral()),
            Action::make('Sorteio')
                ->label('Sorteio PDF')
                ->icon('heroicon-o-gift')
                ->color('warning')
                ->requiresConfirmation()
                ->action(fn () => static::gerarPdfSorteio()),
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
        $tamanhos = ['PP', 'P', 'M', 'G', 'GG', 'XG', 'EXG', 'EXGG'];
        $resultado = [];
        $total=0;

        foreach ($tamanhos as $tamanho) {
            $quantidadeEla = Inscricao::where('paroquia_id', $paroquiaId)
                ->whereIn('status_pagamento', (array) $status)
                ->where('tamanho_camisa_ela', $tamanho)
                ->count();

            $quantidadeEle = Inscricao::where('paroquia_id', $paroquiaId)
                ->whereIn('status_pagamento', (array) $status)
                ->where('tamanho_camisa_ele', $tamanho)
                ->count();

            $resultado[$tamanho] = $quantidadeEla + $quantidadeEle;
            $total += $quantidadeEla + $quantidadeEle;
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

    public static function gerarPdfSorteio()
    {
        $inscricoes = Inscricao::where('status_pagamento', 'Pago')
            ->with('paroquia')
            ->inRandomOrder()
            ->get();

        $titulo = 'XXIII Revivendo';

        $pdf = Pdf::loadView('pdf.sorteio', compact('inscricoes', 'titulo'))
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'sorteio_casais_pagos.pdf'
        );
    }

    public static function gerarPdfGeral()
    {
        $tamanhos = ['PP', 'P', 'M', 'G', 'GG', 'XG', 'EXG', 'EXGG'];
        $paroquias = Paroquia::all();

        $tabela = [];
        $totalGeral = array_fill_keys($tamanhos, 0);
        $totalGeral['total'] = 0;

        foreach ($paroquias as $paroquia) {
            $resultado = [];
            $total = 0;

            foreach ($tamanhos as $tamanho) {
                $quantidadeEla = Inscricao::where('paroquia_id', $paroquia->id)
                    ->whereIn('status_pagamento', ['Pago', 'Cortesia', 'Pendente'])
                    ->where('tamanho_camisa_ela', $tamanho)
                    ->count();

                $quantidadeEle = Inscricao::where('paroquia_id', $paroquia->id)
                    ->whereIn('status_pagamento', ['Pago', 'Cortesia', 'Pendente'])
                    ->where('tamanho_camisa_ele', $tamanho)
                    ->count();

                $soma = $quantidadeEla + $quantidadeEle;

                $resultado[$tamanho] = $soma;
                $total += $soma;

                // Acumula total geral
                $totalGeral[$tamanho] += $soma;
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
        $pdf = Pdf::loadView('pdf.inscricoes-geral', [
            'tabela' => $tabela,
            'totalGeral' => $totalGeral,
            'tamanhos' => $tamanhos,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "inscricoes_geral.pdf"
        );
    }

}
