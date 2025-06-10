<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscricaoIndividual extends Model
{
    protected $fillable = [
        'nome',
        'nome_usual',
        'tamanho_camisa',
        'telefone',
        'paymentDate',
        'status_pagamento',
        'paroquia_id'
    ];

    public function paroquia()
    {
        return $this->belongsTo(Paroquia::class);
    }
}
