<?php

namespace App\Filament\Admin\Resources\InscritoIndividuals;

use App\Enums\InvoiceStatus;
use App\Filament\Admin\Resources\InscritoIndividualResource\Pages;
use App\Filament\Admin\Resources\InscritoIndividualResource\RelationManagers;
use App\Filament\Admin\Resources\InscritoIndividuals\Pages\EditInscritoIndividual;
use App\Filament\Admin\Resources\InscritoIndividuals\Pages\ListInscritoIndividuals;
use App\Models\InscricaoIndividual;
use App\Models\InscritoIndividual;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class InscritoIndividualResource extends Resource
{
    protected static ?string $model = InscricaoIndividual::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Inscrições Individuais';

    protected static ?string $modelLabel = 'inscrição individual';
    protected static ?string $pluralModelLabel = 'inscrições individuais';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome_usual'),
                Select::make('paroquia_id')
                    ->label('Paróquia')
                    ->relationship('paroquia', 'name', function (Builder $query) {
                        $query->selectRaw("id, CONCAT(name, ' - ', city) as name");
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Radio::make('status_pagamento')
                    ->label('Status da inscrição')
                    ->inline()
                    ->options(InvoiceStatus::class)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(InscricaoIndividual::query()->orderBy('id','desc'))
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('nome')
                    ->label('Nome completo')
                    ->searchable(['nome','nome_usual'])
                    ->formatStateUsing(fn ($record) => "{$record->nome} ($record->nome_usual)")
                    ->html(),
                TextColumn::make('telefone')
                    ->formatStateUsing(fn ($state) => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                TextColumn::make('paroquia.name')
                    ->label('Paróquia')
                    ->formatStateUsing(fn ($record) => "{$record->paroquia->name} - {$record->paroquia->city}"),
                BadgeColumn::make('invoice.status')
                    ->label('Status do Pagamento')
                    ->getStateUsing(fn ($record) => $record->invoice?->status ?? 'sem_invoice')
                    ->colors([
                        'success' => 'Pago',
                        'warning' => 'Cortesia',
                        'danger' => 'Cancelado',
                        'gray' => 'Pendente',
                    ]),

                TextColumn::make('invoice.paymentDate')
                    ->label('Pago em')
                    ->date('d/m/Y'),
                TextColumn::make('created_at')
                    ->label('Inscrito em')
                    ->date('d/m/Y h:m:i')
            ])
            ->filters([
                SelectFilter::make('invoice.status')
                    ->label('Filtrar por Paróquia')
                    ->searchable()
                    ->preload()
                    ->relationship('paroquia', 'name', function ($query) {
                        $query->selectRaw("id, CONCAT(name, ' - ', city) as name");
                    }),
            ])
            ->recordActions([
                Action::make('marcarPago')
                    ->label('Marcar Pago')
                    ->icon('heroicon-o-check-circle')
                    ->button()
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading("Confirmar Pagamento?")
                    ->modalDescription(fn ($record) =>
                    new HtmlString(
                        "<b>{$record->nome}</b> <br>
                         {$record->paroquia->name} de {$record->paroquia->city}")
                    )
                    ->action(fn ($record) => $record->update([
                        'paymentDate' => Carbon::now(),
                        'status_pagamento' => 'Pago',
                        'forma_de_pagamento' => 'Manual ou Cartão'
                    ]))
                    ->successNotificationTitle('Pagamento confirmado com sucesso!')
                    ->hidden(fn ($record) => $record->invoice->status === 'Pago' OR $record->invoice->status === 'Cortesia'),
                EditAction::make()
                    ->label('Editar')
                    ->iconButton(),
                DeleteAction::make()
                    ->label('Remover')
                    ->requiresConfirmation()
                    ->iconButton()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
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
            'index' => ListInscritoIndividuals::route('/'),
            //'create' => Pages\CreateInscritoIndividual::route('/create'),
            'edit' => EditInscritoIndividual::route('/{record}/edit'),
        ];
    }
}
