@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="row">
    <!-- Formularço de envio de Pergunta -->
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

    <!-- Lista de Perguntas (TICKET #002) -->
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold m-0">📋 Perguntas do Evento</h4>
            <span class="text-secondary small">Total no Banco: {{ $evento->perguntas->count() }}</span>
        </div>

        @forelse($perguntas as $pergunta)
            <div class="card mb-3 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <p class="fs-5 mb-2 text-white">{{ $pergunta->texto }}</p>
                    <div class="d-flex justify-content-between align-items-center text-secondary small">
                        <span>Status: <span class="badge bg-success">{{ $pergunta->status }}</span></span>
                        <span>Votos: <span>{{ $pergunta->votos_count }}</span></span>
                        <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                        @php
                        // Verifica se o usuário logado está na lista de votos da pergunta
                        $jaVotou = auth()->check() && $pergunta->votos->contains('user_id', auth()->id());
                        @endphp
                
                        @if($jaVotou)
                        {{-- Botão Destacado (Remover Voto) --}}
                        <button type="submit" class="btn btn-primary btn-sm d-flex flex-column align-items-center px-3 py-2 border-0" title="Você já votou! Clique para remover o seu voto">
                            <i class="bi bi-caret-up-fill fs-5 lh-1"></i>
                            <span class="fw-bold mt-1 text-white">{{ $pergunta->votos_count }}</span>
                        </button>
                        @else
                        {{-- Botão Padrão (Adicionar Voto) --}}
                        <button type="submit" class="btn btn-outline-secondary btn-sm d-flex flex-column align-items-center px-3 py-2 text-secondary" title="Clique para votar nesta pergunta">
                            <i class="bi bi-caret-up fs-5 lh-1"></i>
                            <span class="fw-bold mt-1">{{ $pergunta->votos_count }}</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-dark text-center p-4">
                Nenhuma pergunta enviada ainda. Seja o primeiro!
            </div>
        @endforelse

        <!-- TICKET #002: Renderização dos Botões de Paginação -->
        @if(method_exists($perguntas, 'links'))
            <div class="d-flex justify-content-center mt-4">
                
            </div>
        @endif
    </div>
</div>
@endsection
