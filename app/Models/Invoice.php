<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'valor',
        'status',
        'gateway',
        'external_id',
        'pix_qrcode',
        'pix_copia_cola',
        'pix_expira_em',
    ];

    public function invoiceable()
    {
        return $this->morphTo();
    }
}
