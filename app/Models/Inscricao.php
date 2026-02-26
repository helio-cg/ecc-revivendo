<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscricao extends Model
{
    use HasFactory;

    protected $table = 'inscricoes';

    protected $fillable = [
        'nome_ele',
        'nome_ela',
        'nome_usual_ele',
        'nome_usual_ela',
        'tamanho_camisa_ele',
        'tamanho_camisa_ela',
        'telefone',
        'paymentDate',
        'status_pagamento',
        'paroquia_id'
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
