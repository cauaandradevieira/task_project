<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarefaController extends Controller
{
    public function index()
    {
        $tarefas = Tarefa::orderBy('ordem_apresentacao')->get();

        $totalCusto = $tarefas->sum('custo');
        $totalCustoFormatado = number_format($totalCusto, 2, ',', '.');

        return view('tarefas', ['tarefas' => $tarefas, 'totalCusto' => $totalCustoFormatado]);
    }

    public function create()
    {
        $tarefas = Tarefa::orderBy('ordem_apresentacao')->get();

        $totalCusto = $tarefas->sum('custo');
        $totalCustoFormatado = number_format($totalCusto, 2, ',', '.');

        return view('criar', ['totalCusto' => $totalCustoFormatado]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'custo' => str_replace(',', '.', str_replace('.', '', $request->custo)),
        ]);

        $request->validate([

            'nome' => 'required|max:255|unique:tarefas,nome',
            'custo' => 'required|numeric|min:0.01|max:99999999.99',
            'data_limite' => 'required|date|after_or_equal:today',
        ], [
            'nome.required' => 'O nome da tarefa é obrigatório.',
            'nome.unique' => 'Já existe uma tarefa com esse nome.',
            'nome.max' => 'O nome pode ter no máximo 255 caracteres.',

            'custo.required' => 'O custo é obrigatório.',
            'custo.numeric' => 'O custo deve ser um número válido.',
            'custo.min' => 'O custo não pode ser negativo.',
            'custo.max' => 'O custo informado é muito alto.',

            'data_limite.required' => 'A data limite é obrigatória.',
            'data_limite.date' => 'Informe uma data válida.',
            'data_limite.after_or_equal' => 'A data limite não pode ser anterior a hoje.',
        ]);

        $ultimaOrdem = Tarefa::max('ordem_apresentacao') ?? 0;

        Tarefa::create([
            'nome' => $request->nome,
            'custo' => $request->custo,
            'data_limite' => $request->data_limite,
            'ordem_apresentacao' => $ultimaOrdem + 1,
        ]);

        return redirect()
            ->route('tarefas.index')
            ->with('success', 'Tarefa cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $tarefas = Tarefa::orderBy('ordem_apresentacao')->get();

        $tarefaEncontrada = $tarefas->findOrFail($id);

        $totalCusto = $tarefas->sum('custo');
        $totalCustoFormatado = number_format($totalCusto, 2, ',', '.');

        return view('edit', ['tarefa' => $tarefaEncontrada, 'totalCusto' => $totalCustoFormatado]);
    }

    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);

        $request->merge([
            'custo' => str_replace(',', '.', str_replace('.', '', $request->custo)),
        ]);

        $request->validate([
            'nome' => 'required|max:255|unique:tarefas,nome,'.$tarefa->id,
            'custo' => 'required|numeric|min:0.00|max:99999999.99',
            'data_limite' => 'required|date|after_or_equal:today',
        ], [

            'nome.required' => 'O nome da tarefa é obrigatório.',
            'nome.unique' => 'Já existe uma tarefa com esse nome.',
            'nome.max' => 'O nome pode ter no máximo 255 caracteres.',

            'custo.required' => 'O custo é obrigatório.',
            'custo.numeric' => 'O custo deve ser um número válido.',
            'custo.min' => 'O custo não pode ser negativo.',
            'custo.max' => 'O custo informado é muito alto.',

            'data_limite.required' => 'A data limite é obrigatória.',
            'data_limite.date' => 'Informe uma data válida.',
            'data_limite.after_or_equal' => 'A data limite não pode ser anterior a hoje.',
        ]);

        $tarefa->update([
            'nome' => $request->nome,
            'custo' => $request->custo,
            'data_limite' => $request->data_limite,
        ]);

        return redirect()
            ->route('tarefas.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
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

        return redirect()
            ->route('tarefas.index')
            ->with('success', 'Tarefa removida com sucesso!');
    }

    public function trocarPosicao($id, $tipo)
    {
        DB::transaction(function () use ($id, $tipo) {
            $tarefa = Tarefa::findOrFail($id);
            $ordemAtual = $tarefa->ordem_apresentacao;

            if ($tipo === 'SUBIR') {
                $tarefaAcima = Tarefa::where('ordem_apresentacao', $ordemAtual - 1)->first();

                if ($tarefaAcima) {

                    $tarefa->update(['ordem_apresentacao' => -1]);

                    $tarefaAcima->update(['ordem_apresentacao' => $ordemAtual]);

                    $tarefa->update(['ordem_apresentacao' => $ordemAtual - 1]);
                }
            } elseif ($tipo === 'DESCER') {
                $tarefaAbaixo = Tarefa::where('ordem_apresentacao', $ordemAtual + 1)->first();

                if ($tarefaAbaixo) {

                    $tarefa->update(['ordem_apresentacao' => -1]);

                    $tarefaAbaixo->update(['ordem_apresentacao' => $ordemAtual]);

                    $tarefa->update(['ordem_apresentacao' => $ordemAtual + 1]);
                }
            }
        });

        return redirect()
            ->route('tarefas.index')
            ->with('success', 'Ordem alterada com sucesso!');
    }
}
