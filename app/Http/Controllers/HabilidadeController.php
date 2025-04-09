<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Habilidade;

class HabilidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //não vai ter, as habilidades são predefinidas no BD

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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pessoas)
    {

        //se pá que vai ser no BD direto, não sei se vai ter update

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
