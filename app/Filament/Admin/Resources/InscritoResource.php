<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Inscrito;
use Filament\Forms\Form;
use App\Models\Inscricao;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\InscritoResource\Pages;
use App\Filament\Admin\Resources\InscritoResource\RelationManagers;

class InscritoResource extends Resource
{
    protected static ?string $model = Inscricao::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Incrições';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                    ->badge(),
                TextColumn::make('paymentDate')
                    ->label('Pago em'),
                TextColumn::make('created_at')
                    ->label('Inscrito em')
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
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
