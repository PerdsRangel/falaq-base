@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md mt-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Criar Novo Evento</h1>

    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf

        {{-- Campo Título (Tickets #007 e #008) --}}
        <div class="mb-4">
            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">
                Título do Evento
            </label>
            <input 
                type="text" 
                name="titulo" 
                id="titulo" 
                value="{{ old('titulo') }}"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @else border-gray-300 @enderror"
                placeholder="Digite o título do evento"
            >
            @error('titulo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Campo Descrição (Tickets #007 e #008) --}}
        <div class="mb-6">
            <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">
                Descrição
            </label>
            <textarea 
                name="descricao" 
                id="descricao" 
                rows="4"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descricao') border-red-500 @else border-gray-300 @enderror"
                placeholder="Descreva os detalhes do evento..."
            >{{ old('descricao') }}</textarea>
            @error('descricao')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botão de Submissão Estilizado (Ticket #007) --}}
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-150 font-medium"
            >
                Criar Evento
            </button>
        </div>
    </form>
</div>
@endsection