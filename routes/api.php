<?php

use App\Http\OpenPix\Callback;
use Illuminate\Support\Facades\Route;

Route::get('/teste-api', function () {
    return 'API OK';
});

Route::post('/openpix/chargeCreated', [Callback::class, 'chargeCreated'])->name('openpix.chargeCreated');
Route::post('/openpix/chargeCompleted', [Callback::class, 'chargeCompleted'])->name('openpix.chargeCompleted');
