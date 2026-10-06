<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerguntaController extends Controller
{
    // Ticket #011: Lógica de alternância de votos
    public function votar(Pergunta $pergunta)
    {
        $pergunta->votos()->toggle(Auth::id());

        return back()->with('sucesso', 'Voto atualizado com sucesso!');
    }
}