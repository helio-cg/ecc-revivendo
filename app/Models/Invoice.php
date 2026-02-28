<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'transactionID',
        'valor',
        'status',
        'paymentDate',
        'invoiceUrl'
    ];

    public function invoiceable()
    {
        return $this->morphTo();
    }
}
