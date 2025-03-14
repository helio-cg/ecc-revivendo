<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscricaoController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/inscricao', [InscricaoController::class, 'create'])->name('inscricao.form');
Route::post('/inscricao', [InscricaoController::class, 'store'])->name('inscricao.store');

Route::get('/consultar-inscricao', [InscricaoController::class, 'consultar'])->name('inscricao.consultar');
Route::post('/buscar-inscricao', [InscricaoController::class, 'buscar'])->name('inscricao.buscar');

Route::get('/status-inscricao/{telefone}', [InscricaoController::class, 'status'])->name('inscricao.status');
