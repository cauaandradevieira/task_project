{{-- resources/views/create.blade.php --}}
@extends('principal')

@section('content')

<div class="container mx-auto px-4 py-8">

    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Cadastrar Tarefa</h2>

        <form method="POST" action="{{ route('tarefas.store') }}">
            @csrf

            <!-- Nome da Tarefa -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nome da Tarefa</label>
                <input type="text" name="nome" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('nome') }}">
            </div>

            <!-- Custo -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Custo (R$)</label>
                <input type="number" name="custo" min="0" step="0.01" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('custo') }}">
            </div>

            <!-- Data Limite -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Data Limite</label>
                <input type="date" name="data_limite" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ old('data_limite') }}">
            </div>

            <!-- Botão -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Salvar
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
