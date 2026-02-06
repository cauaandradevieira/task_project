<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use DB;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    
    public function index()
    {
        $tarefas = Tarefa::orderBy('ordem_apresentacao')->get();

        $totalCusto = $tarefas->sum('custo');
        $totalCustoFormatado = number_format($totalCusto, 2, ',', '.'); 

        return view('tarefas', ['tarefas' => $tarefas, 'totalCusto' => $totalCustoFormatado ]);
    }

    public function create()
    {
        $tarefas = Tarefa::orderBy('ordem_apresentacao')->get();

        $totalCusto = $tarefas->sum('custo');
        $totalCustoFormatado = number_format($totalCusto, 2, ',', '.'); 

        return view('criar', ['totalCusto' => $totalCustoFormatado ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:tarefas,nome',
            'custo' => 'required|numeric|min:1',
            'data_limite' => 'required|date',
        ]);

        $ultimaOrdem = Tarefa::max('ordem_apresentacao') ?? 0;

        Tarefa::create([
            'nome' => $request->nome,
            'custo' => $request->custo,
            'data_limite' => $request->data_limite,
            'ordem_apresentacao' => $ultimaOrdem + 1,
        ]);

        return redirect()->route('tarefas.index');
    }

    public function edit($id)
    {
        $tarefas = Tarefa::orderBy('ordem_apresentacao')->get();
        
        $tarefaEncontrada = $tarefas->findOrFail($id);

        $totalCusto = $tarefas->sum('custo');
        $totalCustoFormatado = number_format($totalCusto, 2, ',', '.'); 

        return view('edit', ['tarefa' => $tarefaEncontrada, 'totalCusto' => $totalCustoFormatado ]);
    }

    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);

        $request->validate([
            'nome' => 'required|unique:tarefas,nome,' . $tarefa->id,
            'custo' => 'required|numeric|min:1',
            'data_limite' => 'required|date',
        ]);

        $tarefa->update([
            'nome' => $request->nome,
            'custo' => $request->custo,
            'data_limite' => $request->data_limite,
        ]);

        return redirect()->route('tarefas.index');
    }

    public function destroy($id)
    {

        DB::transaction(function () use ($id) {

            $tarefa = Tarefa::findOrFail($id);
            $ordemExcluida = $tarefa->ordem_apresentacao;

            $tarefa->delete();

            Tarefa::where('ordem_apresentacao', '>', $ordemExcluida)
                ->decrement('ordem_apresentacao');
        });

        return redirect()->route('tarefas.index');
    }

    public function trocarPosicao($id, $tipo)
    {
        DB::transaction(function () use ($id, $tipo) 
        {
            $tarefa = Tarefa::findOrFail($id);
            $ordemAtual = $tarefa->ordem_apresentacao;

            if ($tipo === "SUBIR") 
            {
                $tarefaAcima = Tarefa::where('ordem_apresentacao', $ordemAtual - 1)->first();

                if ($tarefaAcima) {

                    $tarefa->update(['ordem_apresentacao' => 999999]);


                    $tarefaAcima->update(['ordem_apresentacao' => $ordemAtual]);


                    $tarefa->update(['ordem_apresentacao' => $ordemAtual - 1]);
                }
            } 
            
            elseif ($tipo === "DESCER") 
            {

                $tarefaAbaixo = Tarefa::where('ordem_apresentacao', $ordemAtual + 1)->first();

                if ($tarefaAbaixo) {

                    $tarefa->update(['ordem_apresentacao' => 999999]);


                    $tarefaAbaixo->update(['ordem_apresentacao' => $ordemAtual]);


                    $tarefa->update(['ordem_apresentacao' => $ordemAtual + 1]);
                }
            }
        });

        return redirect()->route('tarefas.index');
    }
}
