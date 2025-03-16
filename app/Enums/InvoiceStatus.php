<?php
namespace App\Core\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum InvoiceStatus: string implements HasLabel, HasColor, HasIcon
{
    case PENDING = 'Pendente';
    case PAID = 'Pago';
    case REFUNDED = 'Reembolsado';
    case CANCELED = 'Cancelado';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::PAID => 'Pago',
            self::REFUNDED => 'Reembolsado',
            self::CANCELED => 'Cancelado',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'danger',
            self::PAID => 'success',
            self::REFUNDED => 'info',
            self::CANCELED => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-m-information-circle',
            self::PAID => 'heroicon-m-check-badge',
            self::REFUNDED => 'heroicon-m-check',
            self::CANCELED => 'heroicon-m-x-circle',
        };
    }
}