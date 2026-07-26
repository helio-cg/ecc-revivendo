<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'transactionID',
        'valor',
        'status',
        'paymentDate',
        'invoiceUrl',
        'forma_de_pagamento'
    ];

    public function invoiceable()
    {
        return $this->morphTo();
    }
}
