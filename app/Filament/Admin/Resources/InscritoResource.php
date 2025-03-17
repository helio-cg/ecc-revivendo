<?php

namespace App\Filament\Admin\Resources;

use App\Enums\InvoiceStatus;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Inscrito;
use Filament\Forms\Form;
use App\Models\Inscricao;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\InscritoResource\Pages;
use App\Filament\Admin\Resources\InscritoResource\RelationManagers;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class InscritoResource extends Resource
{
    protected static ?string $model = Inscricao::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Incrições';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome_usual_ele'),
                TextInput::make('nome_usual_ela'),
                Select::make('status_pagamento')
                    ->label('Status de pagamento')
                    ->options(InvoiceStatus::class)
                    ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome_usual_ele')
                    ->label('Nome do casal')
                    ->formatStateUsing(fn (Model $record): string => $record->nome_usual_ele . ' & ' . $record->nome_usual_ela),
                TextColumn::make('nome_ele')
                    ->label('Nome completo')
                    ->formatStateUsing(fn ($record) => "{$record->nome_ele}<br>{$record->nome_ela}")
                    ->html(),
                TextColumn::make('telefone')
                    ->formatStateUsing(fn ($state) => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                TextColumn::make('status_pagamento')
                    ->label('Status do Pagamento')
                    ->badge()
                    ->color(fn ($record) => match ($record->status_pagamento) {
                        'Pago' => 'success',  // Verde
                        'Pendente' => 'warning', // Amarelo
                        'Cancelado' => 'danger', // Vermelho
                        default => 'secondary', // Cinza para outros casos
                    }),
                TextColumn::make('paymentDate')
                    ->label('Pago em'),
                TextColumn::make('created_at')
                    ->label('Inscrito em')
            ])
            ->filters([
                //
            ])
            ->actions([

                Action::make('marcarPago')
                    ->label('Marcar Pago')
                    ->icon('heroicon-o-check-circle')
                    ->button()
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => "Confirmar Pagamento de {$record->nome_ele} & {$record->nome_ela}?")
                    ->action(fn ($record) => $record->update([
                        'paymentDate' => Carbon::now(),
                        'status_pagamento' => 'Pago',
                    ]))
                    ->successNotificationTitle('Pagamento confirmado com sucesso!')
                    ->hidden(fn ($record) => $record->status_pagamento === 'Pago'),
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInscritos::route('/'),
            'create' => Pages\CreateInscrito::route('/create'),
            'edit' => Pages\EditInscrito::route('/{record}/edit'),
        ];
    }
}
