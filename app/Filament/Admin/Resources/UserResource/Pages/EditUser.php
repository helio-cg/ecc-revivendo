<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Mail\NewPassword;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\UserResource;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('email_password')
                ->label('Enviar senha por e-mail')
                ->action(fn ($record) => self::emailPassword($record)),
            Action::make('password')
                ->label('Alterar Senha')
                ->color('success')
                ->icon('heroicon-o-key')
                ->form([
                    TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->revealable()
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(),
                ])
                ->action(function (array $data, User $record): void {
                    $record->update([
                        'password' => $data['password'],
                    ]);
                }),
        ];
    }

    protected static function emailPassword(object $record): void
    {
        $novaSenha = Str::random(10);
        $record->update([
            'password' => $novaSenha,
        ]);

        Mail::to($record->email)->send(new NewPassword($record, $novaSenha));

        Notification::make()
            ->title('Nova senha enviada para '.$record->email)
            ->success()
            ->send();
    }
}
