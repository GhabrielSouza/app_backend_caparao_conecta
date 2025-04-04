<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cidade;
use App\Models\Pais;

class CidadeController extends Controller
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

        /*
            Estilo de envio dos dados

            "nome_cidade": "Alegre",
            "id_pais": 1

        */
        
        $cidade = new Cidade;
        
        $cidade->nome_cidade = $request->nome_cidade;
        $cidade->id_pais = $request->id_pais;

        $cidade->save();

        return response()->json([
            'mensagem' => 'Cidade cadastrada com sucesso',
            'data - cidade' => $cidade
            
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_cidades)
    {
    
        $cidade = Cidade::find($id_cidades);
        $pais = Pais::where('id_pais', $cidade->id_pais)->first()->toArray();

        return response()->json([
            'data - cidade' => $cidade,
            'data - pais' => $pais
            
        ], 200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_cidades)
    {
        
        $cidade = Cidade::findOrFail($id_cidades);

        $cidade->nome_cidade = $request->nome_cidade;
        $cidade->id_pais = $request->id_pais;

        $cidade->save();

        return response()->json([
            'mensage' => 'Dados da cidade foram atualizados com sucesso',
            'data - cidade' => $cidade
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_cidades)
    {
        
        Cidade::findOrFail( $id_cidades )->delete();

        return response()->json([
            'mensage' => 'Cidade deletada com sucesso',
        ], 200);

    }
}
