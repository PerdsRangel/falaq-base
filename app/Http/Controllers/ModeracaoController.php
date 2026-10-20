<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeracaoRequest;
use App\Models\Evento;
use App\Models\Moderacao;
use App\Models\Pergunta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ModeracaoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Listar a Fila de Moderação do Evento (Eager Loading para evitar problema N+1).
     */
    public function index(Evento $evento)
    {
        $this->authorize('moderate', $evento);

        $moderacoes = Moderacao::whereHas('pergunta', function ($query) use ($evento) {
            $query->where('evento_id', $evento->id);
        })->with('pergunta')->latest()->paginate(15);

        return view('moderacoes.index', compact('evento', 'moderacoes'));
    }

    /**
     * Registrar denúncia para a pergunta.
     */
    public function store(StoreModeracaoRequest $request, Pergunta $pergunta)
    {
        $pergunta->moderacoes()->create($request->validated());

        return redirect()->back()->with('success', 'Denúncia enviada com sucesso!');
    }

    /**
     * Aprovar ou rejeitar a pergunta.
     */
    public function updateStatus(Request $request, Moderacao $moderacao)
    {
        $this->authorize('moderate', $moderacao->pergunta->evento);

        $request->validate([
            'status' => ['required', 'string'],
        ]);

        $moderacao->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status da moderação atualizado com sucesso!');
    }
}