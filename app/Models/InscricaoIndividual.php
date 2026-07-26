<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InscricaoIndividual extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'nome_usual',
        'tamanho_camisa',
        'telefone',
        'paroquia_id',
        'status_pagamento',
        'paymentDate'
    ];

    public function paroquia()
    {
        return $this->belongsTo(Paroquia::class);
    }

    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }
}
