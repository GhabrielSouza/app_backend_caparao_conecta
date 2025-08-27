<?php

namespace App\Http\Controllers;

use App\Models\PessoasFisica;
use Illuminate\Http\Request;
use App\Models\Experiencia;
use App\Models\Formacao_Academica;

use Illuminate\Support\Facades\Validator;

class Formacao_AcademicaController extends Controller
{
    public function index()
    {
        $formacoes = Formacao_Academica::all();
        return response()->json($formacoes);
    }


    public function store(Request $request)
    {
        // --- Validação Corrigida e Melhorada ---
        $rules = [
            'escolaridade' => 'required|string|max:255',
            'area_de_estudo' => 'nullable|string|max:255',
            'diploma_formacao' => 'required|boolean',
            'conclusao_formacao' => 'required|boolean',
            'data_emissao' => 'required|date_format:Y-m-d',
            'data_conclusao' => 'nullable|date_format:Y-m-d|after_or_equal:data_emissao',

            'id_pessoasFisicas' => 'required|integer|exists:pessoas_fisicas,id_pessoas',
            'id_instituicoes' => 'required|integer|exists:instituicoes,id_instituicoes',
        ];

        $messages = [
            'data_conclusao.after_or_equal' => 'A data de conclusão não pode ser anterior à data de emissão.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $formacao = Formacao_Academica::create([
            'area_de_estudo' => $request->input('area_de_estudo'),
            'conclusao_formacao' => $request->input('conclusao_formacao'),
            'data_conclusao' => $request->input('data_conclusao'),
            'data_emissao' => $request->input('data_emissao'),
            'diploma_formacao' => $request->input('diploma_formacao'),
            'escolaridade' => $request->input('escolaridade'),
            'id_instituicoes' => $request->input('id_instituicoes'),
            'id_pessoasFisicas' => $request->input('id_pessoasFisicas'),
        ]);

        return response()->json($formacao, 201);
    }


    public function show($id)
    {
        $formacoes = Formacao_Academica::where('id_pessoasFisicas', $id)->with('instituicao')->get();


        return response()->json($formacoes);
    }



    public function update(Request $request, $id)
    {


        $formacao = Formacao_Academica::find($id);
        if (!$formacao) {
            return response()->json(['message' => 'Formação não encontrada'], 404);
        }

        $rules = [

            'escolaridade' => 'required|string|max:255',
            'area_de_estudo' => 'nullable|string|max:255',
            'diploma_formacao' => 'required|boolean',
            'conclusao_formacao' => 'required|boolean',
            'data_emissao' => 'required|date',
            'data_conclusao' => 'required|date',
            'id_pessoasFisicas' => 'required|integer|exists:App\Models\PessoasFisica,id_pessoas',
            'id_instituicoes' => 'required|integer|exists:instituicoes',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json([
                'error' => $validator->errors()
            ], 422);

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




    public function destroy($id)
    {
        $formacao = Formacao_Academica::find($id);
        if (!$formacao) {
            return response()->json(['message' => 'Formação não encontrada'], 404);
        }

        $formacao->delete();
        if (!$formacao) {
            return response()->json(['message' => 'Erro ao deletar a formação'], 500);
        }
        return response()->json(['message' => 'Formação deletada com sucesso']);
    }

}
