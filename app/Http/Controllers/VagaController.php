<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;

class VagaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Vaga::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos? vai precisar?
        // $request->validate([
        //     'titulo_vaga' => 'required|string|max:255',
        //     'descricao' => 'required|string',
        //     'salario' => 'required|numeric',
        //     'status' => 'required|string|max:50',
        //     'data_criacao' => 'required|date',
        //     'data_fechamento' => 'required|date',
        //     'qtd_vaga' => 'required|integer',
        //     'requisitos' => 'required|string',
        //     'imagem' => 'nullable|image|max:2048',
        //     'qtd_vagas_preenchidas' => 'nullable|integer',
        //     'modalidade_da_vaga' => 'required|string|max:50',
        //     'termo_de_prazo' => 'nullable|string|max:255',
        //     'id_empresa' => 'required|integer'
        // ]);

        $vaga = Vaga::create($request->all());

        return response()->json([
            'mensage' => 'Cliente criado com sucesso',
            'data' => $vaga
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vaga = Vaga::find($id);

        if (!$vaga) {
            return response()->json([
                'mensage' => 'Vaga não encontrada'
            ], 404);
        }

        return response()->json($vaga, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Validação dos dados recebidos? vai precisar?
        // $request->validate([
        //     'titulo_vaga' => 'required|string|max:255',
        //     'descricao' => 'required|string',
        //     'salario' => 'required|numeric',
        //     'status' => 'required|string|max:50',
        //     'data_criacao' => 'required|date',
        //     'data_fechamento' => 'required|date',
        //     'qtd_vaga' => 'required|integer',
        //     'requisitos' => 'required|string',
        //     'imagem' => 'nullable|image|max:2048',
        //     'qtd_vagas_preenchidas' => 'nullable|integer',
        //     'modalidade_da_vaga' => 'required|string|max:50',
        //     'termo_de_prazo' => 'nullable|string|max:255',
        //     'id_empresa' => 'required|integer'
        // ]);

        $vaga = Vaga::find($id);
        if (!$vaga) {
            return response()->json([
                'mensage' => 'Vaga não encontrada'
            ], 404);
        }

        $vaga->update($request->all());

        return response()->json([
            'mensage' => 'Vaga atualizada com sucesso',
            'data' => $vaga
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vaga = Vaga::find($id);
        if (!$vaga) {
            return response()->json([
                'mensage' => 'Vaga não encontrada'
            ], 404);
        }

        $vaga->delete();

        return response()->json([
            'mensage' => 'Vaga deletada com sucesso'
        ], 200);
    }
}
