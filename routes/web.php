<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\InscricaoIndividualController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/* Casal */
//Route::get('/inscricao', [InscricaoController::class, 'create'])->name('inscricao.form');
//Route::post('/inscricao', [InscricaoController::class, 'store'])->name('inscricao.store');

Route::get('/consultar-inscricao', [InscricaoController::class, 'consultar'])->name('inscricao.consultar');
Route::post('/buscar-inscricao', [InscricaoController::class, 'buscar'])->name('inscricao.buscar');

Route::get('/status-inscricao/{telefone}', [InscricaoController::class, 'status'])->name('inscricao.status');

/* Individual */
//Route::get('/inscricao-individual', [InscricaoIndividualController::class, 'create'])->name('inscricao-individual.form');
//Route::post('/inscricao-individual', [InscricaoIndividualController::class, 'store'])->name('inscricao-individual.store');

Route::get('/status-inscricao-individual/{telefone}', [InscricaoIndividualController::class, 'status'])->name('inscricao-individual.status');