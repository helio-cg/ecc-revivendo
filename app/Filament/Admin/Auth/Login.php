<?php
namespace App\Filament\Admin\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseAuth
{
    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        if (app()->environment('local')) {
            $this->form->fill([
                'email' => 'admin@admin.com',
                'password' => 'password',
            ]);
        }
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return __('Admin Login');
    }

    public function getHeading(): string|Htmlable
    {
        return __('Admin Login');
    }

    /* protected function getEmailFormComponent(): Component
     {
         return TextInput::make('username')
             ->label('Username')
             ->required()
             ->autofocus()
             ->extraInputAttributes(['tabindex' => 1])
             ->autocomplete();
     }*/
}
