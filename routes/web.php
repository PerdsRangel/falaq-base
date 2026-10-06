<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\PerguntaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');

// Rota protegida com middleware de autenticação
Route::post('/eventos/{id}/perguntas', [EventoController::class, 'storePergunta'])
    ->name('eventos.perguntas.store')
    ->middleware('auth');

// Ticket #011: Rota de Votação
Route::post('/perguntas/{pergunta}/votar', [PerguntaController::class, 'votar'])
    ->name('perguntas.votar')
    ->middleware('auth');