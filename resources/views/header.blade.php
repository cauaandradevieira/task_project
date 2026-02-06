<!-- Header Moderno -->
<div class="bg-indigo-400 text-white">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center">
            <div class="mb-6 md:mb-0">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-3 rounded-2xl shadow-lg">
                        <i class="fa-solid fa-list text-2xl text-indigo-400"></i>
                    </div>
                    <div>
                        <a href="{{ route('tarefas.index') }}">
                            <h1 class="text-3xl font-bold">Projeto de Tarefas</h1>
                        </a>                       
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="px-6 py-3 rounded-2xl border border-indigo-300 bg-indigo-300/20">
                    <p class="text-sm text-blue-100 font-semibold">Total em tarefas:</p>
                    <p id="total-header" class="text-2xl font-bold">R$ {{ $totalCusto }}</p>
                </div>
                <a href="{{ route('tarefas.create') }}"
                    class="bg-white text-indigo-600 hover:bg-gray-50 font-semibold py-3 px-6 rounded-xl 
                               flex items-center  shadow-lg hover:shadow-xl transition-all duration-300 text-lg cursor-pointer">
                    <i class="fa-solid fa-plus mr-2"></i>
                    <span>nova tarefa</span>
                </a>
            </div>
        </div>
    </div>
</div>