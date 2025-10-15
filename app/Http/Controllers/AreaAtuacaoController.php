<?php

namespace App\Http\Controllers;
use App\Models\AreaAtuacao;
use Illuminate\Http\Request;
use Validator;

class AreaAtuacaoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = AreaAtuacao::all();

        return response()->json($areas, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'nome_area' => 'required|string|max:255',
            'status' => 'string|max:45',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $area = new AreaAtuacao();
        $area->nome_area = $request->nome_area;
        $area->status = 'Ativo';
        $area->save();

        return response()->json($area, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $areas = AreaAtuacao::find($id);

        if (!$areas) {
            return response()->json(['message' => 'Área de atuação não encontrada'], 404);
        }

        return response()->json($areas, 200);
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'nome_area' => 'required|string|max:255',
            'status' => 'string|max:45',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $areas = AreaAtuacao::find($id);

        if (!$areas) {
            return response()->json(['error' => 'Área de atuação não encontrada'], 404);
        }

        $areas->nome_area = $request->nome_area;
        $areas->status = 'Ativo';
        $areas->save();

        return response()->json($areas, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = AreaAtuacao::find($id);

        if ($area) {
            $area->delete();
            return response()->json(['message' => 'Área de atuação deletada com sucesso'], 200);
        } else {
            return response()->json(['message' => 'Área de atuação não encontrada'], 404);
        }
    }
}
