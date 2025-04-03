<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;

use Illuminate\Http\Request;

use App\Models\Pessoa;

class PessoaController extends Controller
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

            "id_pessoas": 2,
            "nome": "Cleiton",
            "telefone": "28992228225",
            "sobre": "Marceneiro",

            "cnpj": "123456789",

            "email": "cleiton@gmail.com",
            "senha": "123456",
            "id_tipo_usuarios": 3

        */
        
        $pessoa = new Pessoa;
        
        $pessoa->id_pessoas = $request->id_pessoas;
        $pessoa->nome = $request->nome;
        $pessoa->telefone = $request->telefone;
        $pessoa->sobre = $request->sobre;
        $pessoa->imagem = $request->imagem;

        $pessoa->save();

        app('App\Http\Controllers\EmpresaController')->store($request); //manda a variável request para a função store() do controller da empresa
        app('App\Http\Controllers\UsuarioController')->store($request); //mesma coisa, só que pro controller do usuário

        return response()->json([
            'mensage' => 'Pessoa cadastrada com sucesso',
            'data' => $pessoa
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pessoas)
    {

        $pessoa = Pessoa::find($id_pessoas);
        $empresa = app('App\Http\Controllers\EmpresaController')->show($id_pessoas); //manda a variável id_pessoas para a função show() do controller da empresa, que retorna as colunas da tabela
        $usuario = app('App\Http\Controllers\UsuarioController')->show($id_pessoas); //manda a variável id_pessoas para a função show() do controller de usuario, que também retorna as colunas da tabela

        return response()->json([
            'data - pessoa' => $pessoa,
            'data - empresa' => $empresa,
            'data - usuario' => $usuario
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_pessoas)
    {
        
        Pessoa::findOrFail( $id_pessoas )->deleteOnCascade();

        return response()->json([
            'mensage' => 'Pessoa, empresa e usuário deletada com sucesso',
        ], 200);

    }
}
