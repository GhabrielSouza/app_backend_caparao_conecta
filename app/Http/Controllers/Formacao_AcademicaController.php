<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experiencia;
use App\Models\Formacao_Academica;

class Formacao_AcademicaController extends Controller
{
    public function index(){
        //
    }

    public function all(){
        $formacoes = Formacao_Academica::all();
        return response()->json($formacoes);
    }

    public function store(Request $request){

    /*
        Modelo de inserção de dados via json:
    {
        "area_de_estudo":"Machine Learning",
        "conclusao_formacao":1,
        "data_conclusao":"20021212",
        "data_emissao":"20021212",
        "diploma_formacao":1,
        "escolaridade":"Segundo Grau",
        "id_instituicoes":2,
        "id_pessoasFisicas":1
    }
    */
        $formacao = new Formacao_Academica();

        $formacao->area_de_estudo = $request->area_de_estudo;
        $formacao->conclusao_formacao = $request->conclusao_formacao;
        $formacao->data_conclusao = $request->data_conclusao;
        $formacao->data_emissao = $request->data_emissao;
        $formacao->diploma_formacao = $request->diploma_formacao;
        $formacao->escolaridade = $request->escolaridade;
        $formacao->id_instituicoes = $request->id_instituicoes;
        $formacao->id_pessoasFisicas = $request->id_pessoasFisicas;

        $formacao->save();

        return response()->json($formacao, 201);
    }


    public function show($id){
        $formacao = Formacao_Academica::find($id);
        if (!$formacao) {
            return response()->json(['message' => 'Formação não encontrada'], 404);
        }
        return response()->json($formacao);
    }



    public function update(Request $request, $id){

/*
        Modelo de inserção de dados via json: ====> Passar o id da formação a ser alterada na url
    {
        "area_de_estudo":"Machine Learning",
        "conclusao_formacao":1,
        "data_conclusao":"20021212",
        "data_emissao":"20021212",
        "diploma_formacao":1,
        "escolaridade":"Segundo Grau",
        "id_instituicoes":2,
        "id_pessoasFisicas":1
    }
    */

        $formacao = Formacao_Academica::find($id);
        if (!$formacao) {
            return response()->json(['message' => 'Formação não encontrada'], 404);
        }

        $formacao->area_de_estudo = $request->area_de_estudo;
        $formacao->conclusao_formacao = $request->conclusao_formacao;
        $formacao->data_conclusao = $request->data_conclusao;
        $formacao->data_emissao = $request->data_emissao;
        $formacao->diploma_formacao = $request->diploma_formacao;
        $formacao->escolaridade = $request->escolaridade;
        $formacao->id_instituicoes = $request->id_instituicoes;
        $formacao->id_pessoasFisicas = $request->id_pessoasFisicas;

        $formacao->save();

        return response()->json($formacao);
    }



    
    public function destroy($id){
        $formacao = Formacao_Academica::find($id);
        if (!$formacao) {
            return response()->json(['message' => 'Formação não encontrada'], 404);
        }

        $formacao->delete();
        if(!$formacao) {
            return response()->json(['message' => 'Erro ao deletar a formação'], 500);
        }
        return response()->json(['message' => 'Formação deletada com sucesso']);
    }

}
