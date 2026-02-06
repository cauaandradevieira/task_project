
@extends('principal')

@section('content')

<div class="container mx-auto px-4 py-8">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden pe-4 pl-4 mb-4">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Tarefas</h2>
            </div>
        </div>

        @foreach ($tarefas as $tarefa)
            <div class="task-card rounded-xl border border-gray-200 p-5 mb-4 shadow-sm smooth-transition {{ $tarefa->custo >= 1000 ? 'bg-red-100' : 'bg-white' }}">
                <div class="flex items-center justify-between">
                    <div class="space-x-4 flex-1">
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $tarefa->nome }}</h4>
                            <div class="flex flex-wrap items-center gap-4 mt-2">
                                <span class="items-center text-sm">
                                    <i class="fas fa-money-bill-wave mr-1.5"></i>
                                    {{ $tarefa->custo }}
                                </span>
                                <span>Ordem: {{ $tarefa->ordem_apresentacao }}</span>
                                <span>Data: {{ $tarefa->data_limite->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 ml-4">

                        @if(!$loop->first)
                        <form action="{{ route('tarefas.trocarPosicao', [$tarefa->id, 'SUBIR']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-3 rounded-xl transition duration-200">
                                <i class="fa-solid fa-arrow-up"></i>
                            </button>
                        </form>
                        @endif

                        @if(!$loop->last)
                        <form action="{{ route('tarefas.trocarPosicao', [$tarefa->id, 'DESCER']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-3 rounded-xl transition duration-200">
                                <i class="fa-solid fa-arrow-down"></i>
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('tarefas.edit', $tarefa->id) }}"
                            class="bg-yellow-50 hover:bg-yellow-100 text-yellow-600 p-3 rounded-xl transition duration-200">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-50 hover:bg-red-100 text-red-600 p-3 rounded-xl">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

@endsection
