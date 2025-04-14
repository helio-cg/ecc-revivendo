<?php

namespace App\Filament\Admin\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Inscrito;
use App\Models\Paroquia;
use Filament\Forms\Form;
use App\Models\Inscricao;
use Filament\Tables\Table;
use App\Enums\InvoiceStatus;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\InscritoResource\Pages;
use App\Filament\Admin\Resources\InscritoResource\RelationManagers;

class InscritoResource extends Resource
{
    protected static ?string $model = Inscricao::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Inscrição';

    protected static ?string $navigationLabel = 'Inscrições';

    protected static ?string $modelLabel = 'inscrição';
    protected static ?string $pluralModelLabel = 'inscrições';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome_usual_ele'),
                TextInput::make('nome_usual_ela'),
                Radio::make('status_pagamento')
                    ->label('Status da inscrição')
                    ->inline()
                    ->options(InvoiceStatus::class)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Inscricao::query()->orderBy('id','desc'))
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('nome_ele')
                    ->label('Nome completo')
                    ->searchable(['nome_ele','nome_ela','nome_usual_ele','nome_usual_ela'])
                    ->formatStateUsing(fn ($record) => "{$record->nome_ele} ($record->nome_usual_ele)<br>{$record->nome_ela} ($record->nome_usual_ela)")
                    ->html(),
                TextColumn::make('telefone')
                    ->formatStateUsing(fn ($state) => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                TextColumn::make('paroquia.name')
                    ->label('Paróquia')
                    ->formatStateUsing(fn ($record) => "{$record->paroquia->name} - {$record->paroquia->city}"),
                TextColumn::make('status_pagamento')
                    ->label('Status do Pagamento')
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => match ($record->status_pagamento) {
                        'Pago' => 'success',  // Verde
                        'Pendente' => 'warning', // Amarelo
                        'Cancelado' => 'danger', // Vermelho
                        'Cortesia' => 'info',
                        default => 'secondary', // Cinza para outros casos
                    }),
                TextColumn::make('paymentDate')
                    ->label('Pago em')
                    ->date('d/m/Y'),
                TextColumn::make('created_at')
                    ->label('Inscrito em')
                    ->date('d/m/Y h:m:i')
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filtrar por Paróquia')
                    ->searchable()
                    ->preload()
                    ->relationship('paroquia', 'name', function ($query) {
                        $query->selectRaw("id, CONCAT(name, ' - ', city) as name");
                    }),
            ])
            ->actions([

                Action::make('marcarPago')
                    ->label('Marcar Pago')
                    ->icon('heroicon-o-check-circle')
                    ->button()
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading("Confirmar Pagamento?")
                    ->modalDescription(fn ($record) => "{$record->nome_ele} & {$record->nome_ela} - {$record->paroquia->name} de {$record->paroquia->city}")
                    ->action(fn ($record) => $record->update([
                        'paymentDate' => Carbon::now(),
                        'status_pagamento' => 'Pago',
                    ]))
                    ->successNotificationTitle('Pagamento confirmado com sucesso!')
                    ->hidden(fn ($record) => $record->status_pagamento === 'Pago' OR $record->status_pagamento === 'Cortesia'),
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->label('Remover')
                    ->requiresConfirmation()
                    ->iconButton()
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
