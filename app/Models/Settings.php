<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Settings extends Model
{
    protected $fillable = [
        'data_limite',
        'inscricoes_liberadas',
    ];

    protected $casts = [
        'data_limite' => 'date',
        'inscricoes_liberadas' => 'boolean',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate([], [
            'inscricoes_liberadas' => true,
        ]);
    }

    public static function inscricoesAbertas(): bool
    {
        $settings = static::instance();

        if ($settings->inscricoes_liberadas) {
            return true;
        }

        if ($settings->data_limite && Carbon::now()->lt($settings->data_limite)) {
            return true;
        }

        return false;
    }
}
