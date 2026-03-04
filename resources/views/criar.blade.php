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
                        value="{{ old('nome') }}" autofocus>
                </div>

                <!-- Custo -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Custo (R$)</label>
                    <input type="text" name="custo" id="custo" required
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

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-xl border bg-red-100 border-red-300 text-red-700 text-sm font-medium">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

    </div>


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const campo = document.getElementById('custo');
            if (!campo) return;

            campo.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^0-9.,]/g, '');
            });

        });
    </script>
@endpush
