<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experiencia;

class ExperienciaController extends Controller
{
    public function index(){
        return view("experiencias.index");
    }

    public function all(){
        $experiencias = Experiencia::all();
        return response()->json($experiencias);
    }

    public function store(Request $request){

    /*
        Modelo de inserção de dados via json:
    {
        "cargo": "Gerente",
        "nome_empresa": "Caparao JR",
        "comprovacao": 1,
        "descricao": "asdasd",
        "id_pessoasFisicas": 1
    }
    */
        $experiencia = new Experiencia();

        $experiencia->cargo = $request->cargo;
        $experiencia->nome_empresa = $request->nome_empresa;
        $experiencia->comprovacao = $request->comprovacao;
        $experiencia->descricao = $request->descricao;
        $experiencia->id_pessoasFisicas = $request->id_pessoasFisicas;

        $experiencia->save();

        return response()->json($experiencia, 201);
    }


    public function show($id){
        $experiencia = Experiencia::find($id);
        if (!$experiencia) {
            return response()->json(['message' => 'Experiência não encontrada'], 404);
        }
        return response()->json($experiencia);
    }



    public function update(Request $request, $id){

/*
        Modelo de inserção de dados via json: ====> Passar o id da experiencia a ser alterada na url
    {
        "cargo": "Gerente",
        "nome_empresa": "Caparao JR",
        "comprovacao": 1,
        "descricao": "asdasd",
        "id_pessoasFisicas": 1
    }
    */

        $experiencia = Experiencia::find($id);
        if (!$experiencia) {
            return response()->json(['message' => 'Experiência não encontrada'], 404);
        }

        $experiencia->cargo = $request->cargo;
        $experiencia->nome_empresa = $request->nome_empresa;
        $experiencia->comprovacao = $request->comprovacao;
        $experiencia->descricao = $request->descricao;
        $experiencia->id_pessoasFisicas = $request->id_pessoasFisicas;

        $experiencia->save();

        return response()->json($experiencia);
    }



    
    public function destroy($id){
        $experiencia = Experiencia::find($id);
        if (!$experiencia) {
            return response()->json(['message' => 'Experiência não encontrada'], 404);
        }

        $experiencia->delete();
        if(!$experiencia) {
            return response()->json(['message' => 'Erro ao deletar a experiência'], 500);
        }
        return response()->json(['message' => 'Experiência deletada com sucesso']);
    }

}
