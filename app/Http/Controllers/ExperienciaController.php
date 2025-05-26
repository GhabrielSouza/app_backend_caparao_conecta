<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\PessoasFisica;
use Illuminate\Http\Request;
use App\Models\Experiencia;

use Illuminate\Support\Facades\Validator;

class ExperienciaController extends Controller
{
    public function index()
    {
        $experiencias = Experiencia::all();
        return response()->json($experiencias);
    }

    public function store(Request $request)
    {

        $rules = [

            'cargo' => 'required|string|max:255',
            'nome_empresa' => 'string|max:255',
            'comprovacao' => 'required|boolean',
            'descricao' => 'string',
            'data_emissao' => 'date',
            'data_conclusao' => 'nullable|date|required_if:trabalho_atual,false',
            'trabalho_atual' => 'required|boolean',
            'id_pessoasFisicas' => 'required|integer|exists:App\Models\PessoasFisica,id_pessoas',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json([
                'error' => $validator->errors()
            ], 422);

        }



        $experiencia = new Experiencia();
        $experiencia->cargo = $request->cargo;
        $experiencia->nome_empresa = $request->nome_empresa;
        $experiencia->comprovacao = $request->comprovacao;
        $experiencia->descricao = $request->descricao;
        $experiencia->data_emissao = $request->data_emissao;
        $experiencia->trabalho_atual = $request->trabalho_atual;
        $experiencia->id_pessoasFisicas = $request->id_pessoasFisicas;


        $experiencia->data_conclusao = $request->trabalho_atual ? null : $request->data_conclusao;

        $experiencia->save();

        return response()->json($experiencia, 201);
    }


    public function show($id)
    {
        $experiencia = PessoasFisica::with('experiencia')->find($id);
        $experiencias = $experiencia->experiencia;
        if (!$experiencia) {
            return response()->json(['message' => 'Experiência não encontrada'], 404);
        }
        return response()->json($experiencias, 200);
    }



    public function update(Request $request, $id)
    {

        $experiencia = Experiencia::find($id);
        if (!$experiencia) {
            return response()->json(['message' => 'Experiência não encontrada'], 404);
        }

        $rules = [

            'cargo' => 'required|string|max:255',
            'nome_empresa' => 'string|max:255',
            'comprovacao' => 'required|boolean',
            'descricao' => 'string',
            'data_emissao' => 'required|date',
            'data_conclusao' => 'required|date',
            'id_pessoasFisicas' => 'required|integer|exists:App\Models\PessoasFisica,id_pessoas',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json([
                'error' => $validator->errors()
            ], 422);

        }

        $experiencia->cargo = $request->cargo;
        $experiencia->nome_empresa = $request->nome_empresa;
        $experiencia->comprovacao = $request->comprovacao;
        $experiencia->descricao = $request->descricao;
        $experiencia->data_conclusao = $request->data_conclusao;
        $experiencia->data_emissao = $request->data_emissao;
        $experiencia->id_pessoasFisicas = $request->id_pessoasFisicas;

        $experiencia->save();

        return response()->json($experiencia);
    }




    public function destroy($id)
    {
        $experiencia = Experiencia::find($id);
        if (!$experiencia) {
            return response()->json(['message' => 'Experiência não encontrada'], 404);
        }

        $experiencia->delete();
        if (!$experiencia) {
            return response()->json(['message' => 'Erro ao deletar a experiência'], 500);
        }
        return response()->json(['message' => 'Experiência deletada com sucesso']);
    }

}
