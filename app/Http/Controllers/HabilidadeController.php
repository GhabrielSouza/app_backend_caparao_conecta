<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Habilidade;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\returnArgument;
class HabilidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $habilidades = Habilidade::paginate($perPage);
        return response()->json($habilidades, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'nome' => 'required|string|max:255',
            'status' => 'string|max:45',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $habilidades = new Habilidade();
        $habilidades->nome = $request->nome;
        $habilidades->status = 'Ativo';
        $habilidades->save();

        return response()->json($habilidades, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_habilidades)
    {

        $habilidade = Habilidade::find($id_habilidades);

        return response()->json([
            'data - habilidades' => $habilidade
        ], 200);


    }

    public function showAll()
    {
        $habilidades = Habilidade::all();

        return response()->json(
            $habilidades,
            200
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $rules = [
            'nome' => 'required|string|max:255',
            'status' => 'string|max:45',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $habilidades = Habilidade::find($id);

        if (!$habilidades) {
            return response()->json(['error' => 'Habilidade não encontrada'], 404);
        }

        $habilidades->nome = $request->nome;
        $habilidades->status = 'Ativo';
        $habilidades->save();

        return response()->json($habilidades, 201);

    }

    public function toggleStatus($id)
    {
        $habilidade = Habilidade::findOrFail($id);

        $novoStatus = $habilidade->status == 'Ativo' ? 'Inativo' : 'Ativo';

        $habilidade->status = $novoStatus;
        $habilidade->save();

        $mensagem = "Beneficiário " . ($novoStatus == 'Ativo' ? 'Ativado' : 'Inativado') . " com sucesso!";

        return response()->json($mensagem, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_habilidades)
    {

        $habilidade = Habilidade::find($id_habilidades);

        if ($habilidade) {
            $habilidade->delete();
            return response()->json(['message' => 'Habilidade deletada com sucesso'], 200);
        } else {
            return response()->json(['message' => 'Habilidade não encontrada'], 404);
        }

    }
}
