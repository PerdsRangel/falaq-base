<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\ModeracaoController;
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

// Ticket #016: Rotas de Moderação
Route::post('/perguntas/{pergunta}/moderar', [ModeracaoController::class, 'store'])
    ->name('perguntas.moderar')
    ->middleware('auth');

Route::get('/eventos/{evento}/moderacoes', [ModeracaoController::class, 'index'])
    ->name('eventos.moderacoes.index')
    ->middleware('auth');

Route::patch('/moderacoes/{moderacao}/status', [ModeracaoController::class, 'updateStatus'])
    ->name('moderacoes.updateStatus')
    ->middleware('auth');