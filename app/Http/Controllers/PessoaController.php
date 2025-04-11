<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\PessoasFisica;
use App\Models\Usuario;
use App\Models\Cidade;
use App\Models\Vaga;

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

            Se for empresa:

            "id_pessoas": 2, agora é auto increment
            "nome": "Cleiton",
            "telefone": "28992228225",
            "sobre": "Marceneiro",

            "cnpj": "123456789",

            "email": "cleiton@gmail.com",
            "senha": "123456",
            "id_tipo_usuarios": 3,

            "cep": "aaaaa",
            "id_cidades": 1,
            "estado": "São Paulo"

            -------------------------------------

            Se for pessoa física:

            "id_pessoas": 2, agora é auto increment
            "nome": "Cleiton",
            "sobrenome": "Castro Fernandes",
            "data_de_nascimento": "2006-07-02",
            "genero": "Masculino",

            "telefone": "28992228225",
            "sobre": "Marceneiro",

            "cpf": "17462952793",

            "email": "cleiton@gmail.com",
            "senha": "123456",
            "id_tipo_usuarios": 2,

            "cep": "aaaaa",
            "id_cidades": 1,
            "estado": "São Paulo"

        */
        
        $pessoa = new Pessoa;
        
        $pessoa->nome = $request->nome;
        $pessoa->telefone = $request->telefone;
        $pessoa->sobre = $request->sobre;
        $pessoa->imagem = $request->imagem;

        $pessoa->save();

        $request->id_pessoas = $pessoa->id_pessoas; //passa o id_pessoas do auto increment pro request, que consegue levar o id para os outros controllers

        if ($request->id_tipo_usuarios == 3) {

            $empresa = app('App\Http\Controllers\EmpresaController')->store($request); //manda a variável request para a função store() do controller da empresa
            $usuario = app('App\Http\Controllers\UsuarioController')->store($request); //mesma coisa, só que pro controller do usuário
            $endereco = app('App\Http\Controllers\EnderecoController')->store($request); //mesma coisa, só que pro controller do usuário

            return response()->json([
                'mensagem' => 'Pessoa, empresa, endereço e usuario cadastrado com sucesso',
                'data - pessoa' => $pessoa,
                'data - endereço' => $endereco,
                'data - empresa' => $empresa,
                'data - usuario' => $usuario

                
            ], 200);

        }

        if ($request->id_tipo_usuarios == 2) {

            $usuario = app('App\Http\Controllers\UsuarioController')->store($request); //mesma coisa, só que pro controller do usuário
            $endereco = app('App\Http\Controllers\EnderecoController')->store($request); //mesma coisa, só que pro controller do usuário
            $pessoa_fisica = app('App\Http\Controllers\PessoasFisicaController')->store($request); //mesma coisa, só que pro controller do usuário

            return response()->json([
                'mensagem' => 'Pessoa, pessoa física, endereço e usuario cadastrado com sucesso',
                'data - pessoa' => $pessoa,
                'data - endereço' => $endereco,
                'data - pessoa física' => $pessoa_fisica,
                'data - usuario' => $usuario

                
            ], 200);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pessoas)
    {
        //vagas = Vaga::with("habilidades")->find($id_pessoas);
        $pessoa = Pessoa::find($id_pessoas);
        $usuario = Usuario::find($id_pessoas); //manda a variável id_pessoas para a função show() do controller de usuario, que também retorna as colunas da tabela
        $endereco = Endereco::where('id_pessoas', $pessoa->id_pessoas)->first();
        $cidade = Cidade::where('id_cidades', $endereco->id_cidades)->first();

        if ($usuario->id_tipo_usuarios == 3) {

            $empresa = Empresa::find($id_pessoas); //manda a variável id_pessoas para a função show() do controller da empresa, que retorna as colunas da tabela

            return response()->json([
                'data - pessoa' => $pessoa,
                'data - empresa' => $empresa,
                'data - usuario' => $usuario,
                'data - endereço'=> $endereco,
                'data - cidade' => $cidade
            ], 200);

        }

        if ($usuario->id_tipo_usuarios == 2) {
            
            $pessoa_fisica = PessoasFisica::find($id_pessoas); //manda a variável id_pessoas para a função show() do controller da empresa, que retorna as colunas da tabela

            return response()->json([
                'data - pessoa' => $pessoa,
                'data - pessoa física' => $pessoa_fisica,
                'data - usuario' => $usuario,
                'data - endereço'=> $endereco,
                'data - cidade' => $cidade
            ], 200);

        }

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

        $usuario = Usuario::find($id_pessoas);

        $usuario = app('App\Http\Controllers\UsuarioController')->update($request, $id_pessoas); //
        $endereco = app('App\Http\Controllers\EnderecoController')->update($request, $id_pessoas);

        if ($usuario->id_tipo_usuarios == 3) {

            $empresa = app('App\Http\Controllers\EmpresaController')->update($request, $id_pessoas); //

            return response()->json([
                'mensagem' => 'Dados da pessoa jurídica, empresa, usuário e endereço foram atualizados com sucesso',
                'data - pessoa' => $pessoa,
                'data - empresa' => $empresa,
                'data - usuario' => $usuario,
                'data - endereco'=> $endereco
            ], 200);
        
    }
    
        if ($usuario->id_tipo_usuarios == 2) {

            $pessoaFisica = app('App\Http\Controllers\PessoasFisicaController')->update($request, $id_pessoas);

            return response()->json([
                'mensagem' => 'Dados da pessoa física, usuário e endereço foram atualizados com sucesso',
                'data - pessoa' => $pessoa,
                'data - empresa' => $pessoaFisica,
                'data - usuario' => $usuario,
                'data - endereco'=> $endereco
            ], 200);

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_pessoas)
    {
        
        Pessoa::findOrFail( $id_pessoas )->delete();

        Endereco::findOrFail( $id_pessoas )->delete();

        if (Usuario::find($id_pessoas)->id_tipo_usuarios == 3){
            Usuario::findOrFail( $id_pessoas )->delete();

            Vaga::where('id_empresas', '=', $id_pessoas)->vagaOnHabilidade()->delete();

            Vaga::where('id_empresas', '=', $id_pessoas)->candidato()->delete();

            //AINDA NÃO DELETA OS CURSOS, vou fazer isso depois Do Chefe conversar com o flávio

            Vaga::where('id_empresas', '=', $id_pessoas)->delete();

            Empresa::findOrFail($id_pessoas)->delete();



            return response()->json([
                'mensage' => 'Tudo relacionado a essa pessoa foi desativado com sucesso',
            ], 200);

        }

        if (Usuario::find($id_pessoas)->id_tipo_usuarios == 2){
            Usuario::findOrFail( $id_pessoas )->delete();

            PessoasFisica::where('id_pessoas','=', $id_pessoas)->candidato()->delete();

            PessoasFisica::where('id_pessoas','=', $id_pessoas)->habilidades()->delete();

            PessoasFisica::findOrFail($id_pessoas)->delete();

            return response()->json([
                'mensage' => 'Tudo relacionado a essa pessoa foi desativado com sucesso',
            ], 200);
        }       

    }
}
