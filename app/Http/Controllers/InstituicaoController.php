<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\returnArgument;
class InstituicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instituicao = Instituicao::all();
        return response()->json($instituicao, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nome' => 'required|string|max:255',
            'id_cidades' => 'required|integer|exists:App\Models\Cidade,id_cidades',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $instituicao = new Instituicao();
        $instituicao->nome = $request->nome;
        $instituicao->id_cidades = $request->id_cidades;
        $instituicao->save();

        return response()->json($instituicao, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instituicao = Instituicao::find($id);

        if (!$instituicao) {
            return response()->json(['error' => 'Instituição não encontrada'], 404);
        }

        return response()->json($instituicao, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'nome' => 'required|string|max:255',
            'id_cidades' => 'required|integer|exists:App\Models\Cidade,id_cidades',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $instituicao = Instituicao::find($id);

        if (!$instituicao) {
            return response()->json(['error' => 'Instituição não encontrada'], 404);
        }

        $instituicao->nome = $request->nome;
        $instituicao->id_cidades = $request->id_cidades;
        $instituicao->save();

        return response()->json($instituicao, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instituicao = Instituicao::find($id);

        if(!$instituicao){
            return response()->json(['message' => 'Instituição não encontrada'], 404);
        }

        if(!$instituicao){
            return response()->json(['message' => 'Erro ao deletar Instituição'], 500);
        }

        $instituicao->delete();

        return response()->json(['message' => 'Instituição deletada com sucesso'], 200);
    }
}
