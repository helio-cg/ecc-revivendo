<?php

use App\Http\OpenPix\Callback;
use Illuminate\Support\Facades\Route;


Route::post('/openpix/chargeCreated', [Callback::class, 'chargeCreated']);
Route::post('/openpix/chargeCompleted', [Callback::class, 'chargeCompleted']);
