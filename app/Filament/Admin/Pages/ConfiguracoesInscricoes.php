<?php

namespace App\Filament\Admin\Pages;

use App\Models\Settings;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfiguracoesInscricoes extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 99;

    protected static ?string $navigationLabel = 'Configuracoes';

    protected static ?string $title = 'Configuracoes de Inscricoes';

    protected string $view = 'filament.admin.pages.configuracoes-inscricoes';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Settings::instance();

        $this->form->fill([
            'data_limite' => $settings->data_limite?->format('Y-m-d'),
            'inscricoes_liberadas' => $settings->inscricoes_liberadas,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Prazo de Inscricoes')
                    ->description('Defina a data limite para inscricoes publicas')
                    ->schema([
                        DatePicker::make('data_limite')
                            ->label('Data Limite')
                            ->helperText('Apos essa data, inscricoes publicas serao bloqueadas')
                            ->native(false),
                        Toggle::make('inscricoes_liberadas')
                            ->label('Liberar inscricoes mesmo apos o prazo')
                            ->helperText('Se ativo, as inscricoes ficam abertas mesmo apos a data limite')
                            ->default(true),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $settings = Settings::instance();
        $settings->update([
            'data_limite' => $data['data_limite'] ?? null,
            'inscricoes_liberadas' => $data['inscricoes_liberadas'],
        ]);

        Notification::make()
            ->title('Configuracoes salvas com sucesso!')
            ->success()
            ->send();
    }
}
