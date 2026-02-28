<?php

namespace App\Filament\Admin\Resources\Inscritos;

use App\Enums\InvoiceStatus;
use App\Filament\Admin\Resources\InscritoResource\Pages;
use App\Filament\Admin\Resources\InscritoResource\RelationManagers;
use App\Filament\Admin\Resources\Inscritos\Pages\CreateInscrito;
use App\Filament\Admin\Resources\Inscritos\Pages\EditInscrito;
use App\Filament\Admin\Resources\Inscritos\Pages\ListInscritos;
use App\Models\Inscricao;
use App\Models\Inscrito;
use App\Models\Paroquia;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class InscritoResource extends Resource
{
    protected static ?string $model = Inscricao::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-ticket';

    //protected static ?string $navigationGroup = 'Inscrição';

    protected static ?string $navigationLabel = 'Inscrições Casais';

    protected static ?string $modelLabel = 'inscrição do casal';
    protected static ?string $pluralModelLabel = 'inscrições de casais';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Dados Ele')
                ->schema([
                    TextInput::make('nome_ele')
                        ->label('Nome completo ele')
                        ->columnSpan(2),
                    TextInput::make('nome_usual_ele')
                        ->columnSpan(2),
                    Select::make('tamanho_camisa_ele')
                        ->label('Tamanho da camisa ELE')
                        ->options([
                            'PP' => 'PP',
                            'P' => 'P',
                            'M' => 'M',
                            'G' => 'G',
                            'GG' => 'GG',
                            'EXG' => 'EXG',
                            'EXGG' => 'EXGG',
                        ])
                        ->required()
                        ->columnSpan(1),
                ])->columns(5),
                Fieldset::make('Dados Ela')
                ->schema([
                    TextInput::make('nome_ela')
                        ->label('Nome completo ela')
                        ->columnSpan(2),
                    TextInput::make('nome_usual_ela')
                        ->columnSpan(2),
                    Select::make('tamanho_camisa_ela')
                        ->label('Tamanho da camisa ELA')
                        ->options([
                            'PP' => 'PP',
                            'P' => 'P',
                            'M' => 'M',
                            'G' => 'G',
                            'GG' => 'GG',
                            'EXG' => 'EXG',
                            'EXGG' => 'EXGG',
                        ])
                        ->required()
                        ->columnSpan(1),
                ])->columns(5),


                Select::make('paroquia_id')
                    ->label('Paróquia')
                    ->options(function () {
                        return Paroquia::query()
                            ->orderBy('city')
                            ->orderBy('name')
                            ->get()
                            ->groupBy('city')
                            ->mapWithKeys(function ($group, $city) {
                                return [
                                    $city => $group->mapWithKeys(function ($paroquia) {
                                        return [
                                            $paroquia->id => "{$paroquia->name} - {$paroquia->city}",
                                        ];
                                    }),
                                ];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->required()
                    ->preload(),

                TextInput::make('telefone')
                    ->required(),
                Radio::make('status_pagamento')
                    ->label('Status da inscrição')
                    ->inline()
                    ->inlineLabel(false)
                    ->options(InvoiceStatus::class)
                    ->required()
            ])->columns(1);
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
                            "<b>{$record->nome_ele} & {$record->nome_ela}</b><br>
                            {$record->paroquia->name} de {$record->paroquia->city}"
                        )
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
            'index' => ListInscritos::route('/'),
            'create' => CreateInscrito::route('/create'),
            'edit' => EditInscrito::route('/{record}/edit'),
        ];
    }
}
