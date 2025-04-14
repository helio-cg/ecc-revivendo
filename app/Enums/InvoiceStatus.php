<?php
namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum InvoiceStatus: string implements HasLabel, HasColor, HasIcon
{
    case PENDING = 'Pendente';
    case PAID = 'Pago';
    case REFUNDED = 'Reembolsado';
    case CANCELED = 'Cancelado';
    case CORTESIA = 'Cortesia';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::PAID => 'Pago',
            self::REFUNDED => 'Reembolsado',
            self::CANCELED => 'Cancelado',
            self::CORTESIA => 'Cortesia'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'danger',
            self::PAID => 'success',
            self::REFUNDED => 'info',
            self::CANCELED => 'gray',
            self::CORTESIA => 'black'
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-m-information-circle',
            self::PAID => 'heroicon-m-check-badge',
            self::REFUNDED => 'heroicon-m-check',
            self::CANCELED => 'heroicon-m-x-circle',
            self::CORTESIA => 'heroicon-m-star'
        };
    }
}