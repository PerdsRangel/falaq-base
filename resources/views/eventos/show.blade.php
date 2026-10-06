@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="row">
    <!-- Formulário de envio de Pergunta -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="fw-bold mb-3">💬 Faça sua Pergunta</h4>
            <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="texto" class="form-label text-secondary">Texto da Pergunta</label>

                    <textarea name="texto" id="texto" rows="4" 
                              class="form-control bg-dark text-white border-secondary @error('texto') is-invalid @enderror"
                              placeholder="Digite sua dúvida ou comentário para o palestrante..."></textarea>

                    @error('texto')
                        <div class="invalid-feedback fw-bold">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Enviar Pergunta</button>
            </form>
        </div>
    </div>

    <!-- Lista de Perguntas -->
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold m-0">📋 Perguntas do Evento</h4>
            <span class="text-secondary small">Total no Banco: {{ $evento->perguntas->count() }}</span>
        </div>

        @forelse($perguntas as $pergunta)
            <div class="card mb-3 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <p class="fs-5 mb-0 text-white">{{ $pergunta->texto }}</p>
                        
                        {{-- Ticket #012: Botão e Contagem de Votos --}}
                        @auth
                            @php
                                $jaVotou = $pergunta->votos()->where('user_id', auth()->id())->exists();
                            @endphp
                            <form action="{{ route('perguntas.votar', $pergunta) }}" method="POST" class="ms-2">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $jaVotou ? 'btn-primary' : 'btn-outline-primary' }} fw-bold">
                                    👍 {{ $pergunta->votos_count }}
                                </button>
                            </form>
                        @else
                            <span class="badge bg-secondary fs-6 ms-2">
                                👍 {{ $pergunta->votos_count }}
                            </span>
                        @endauth
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center text-secondary small mt-3">
                        <!-- TICKET #003: Nome do Autor com Fallback seguro -->
                        <span class="fw-semibold text-light">
                            👤 {{ $pergunta->user->name ?? 'Anônimo' }}
                        </span>

                        <span>Status: <span class="badge bg-success">{{ $pergunta->status }}</span></span>
                        <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-dark text-center p-4">
                Nenhuma pergunta enviada ainda. Seja o primeiro!
            </div>
        @endforelse

        <!-- TICKET #002 / #004: Links de navegação da paginação -->
        @if(method_exists($perguntas, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $perguntas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection