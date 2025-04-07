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
        
        $pessoa = Pessoa::findOrFail($id_pessoas);

        $pessoa->nome = $request->nome;
        $pessoa->telefone = $request->telefone;
        $pessoa->sobre = $request->sobre;
        $pessoa->imagem = $request->imagem;

        $pessoa->save();

        $empresa = app('App\Http\Controllers\EmpresaController')->update($request, $id_pessoas); //
        $usuario = app('App\Http\Controllers\UsuarioController')->update($request, $id_pessoas); //

        return response()->json([
            'mensage' => 'Dados da pessoa jurídica, empresa e usuário foram atualizados com sucesso',
            'data - pessoa' => $pessoa,
            'data - empresa' => $empresa,
            'data - usuario' => $usuario
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_habilidades)
    {
        
        

    }
}
