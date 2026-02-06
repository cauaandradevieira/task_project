<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

// Página inicial mostrando todas as tarefas
Route::get('/', [TarefaController::class, 'index'])->name('tarefas.index');

// Criar nova tarefa
Route::get('/tarefas/criar', [TarefaController::class, 'create'])->name('tarefas.create');
Route::post('/tarefas', [TarefaController::class, 'store'])->name('tarefas.store');

// Editar tarefa
Route::get('/tarefas/{id}/editar', [TarefaController::class, 'edit'])->name('tarefas.edit');
Route::put('/tarefas/{id}', [TarefaController::class, 'update'])->name('tarefas.update');

// Excluir tarefa
Route::delete('/tarefas/{id}', [TarefaController::class, 'destroy'])->name('tarefas.destroy');

// Trocar posição (subir/descendo) - rota com prefixo claro
Route::put('/tarefas/trocar-posicao/{id}/{tipo}', [TarefaController::class, 'trocarPosicao'])->name('tarefas.trocarPosicao');

// Teste de view
Route::get('/test', function () {
    return view('principal');
});
