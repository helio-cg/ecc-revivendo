<?php

use App\Http\Controllers\ConsultarInscricao;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\InscricaoIndividualController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/* Casal */
Route::get('/inscricao', [InscricaoController::class, 'create'])->name('inscricao.form')->middleware('bloquear.inscricoes');
Route::post('/inscricao', [InscricaoController::class, 'store'])->name('inscricao.store')->middleware('bloquear.inscricoes');

Route::get('/status-inscricao/{telefone}', [InscricaoController::class, 'status'])->name('inscricao.status');

/* Individual */
Route::get('/inscricao-individual-secret', [InscricaoIndividualController::class, 'create'])->name('inscricao-individual.form')->middleware('bloquear.inscricoes');
Route::post('/inscricao-individual', [InscricaoIndividualController::class, 'store'])->name('inscricao-individual.store')->middleware('bloquear.inscricoes');

/* Busca */
Route::get('/consultar-inscricao/{telefone}', [ConsultarInscricao::class, 'mostrar'])->name('consultar-inscricao.form');
Route::get('/consultar-inscricao', function () {
    return view('consultar-inscricao');
})->name('consultar.inscricao.form');
