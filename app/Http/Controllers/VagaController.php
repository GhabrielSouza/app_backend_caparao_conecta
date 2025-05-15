<?php

namespace App\Http\Controllers;

use App\Models\Habilidade;
use App\Models\Pessoa;
use App\Models\PessoasFisica;
use App\Models\Vaga;
use Carbon\Carbon;
use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Arr;

class VagaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Vaga::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /*

            "titulo_vaga": "Teste",
            "descricao": "Gerente de estoque",
            "salario": 10250.99,
            "status": "ativo",
            "data_criacao": "02/07/2006",
            "data_fechamento": "02/07/2007",
            "qtd_vaga": 20,
            "modalidade_da_vaga": "presencial",
            "id_empresas": 16

            "qtd_vagas_preenchidas": 12, //NÃO PRECISA de colocar no store, já que sempre vai ser 0 quando criar a vaga

        */

        $rules = [

            'titulo_vaga' => 'required|string|max:255',
            'descricao' => 'string|max:255',
            'salario' => 'required|decimal:2',
            'status' => 'string|max:255',
            'data_criacao' => 'required|date',
            'data_fechamento' => 'required|date',
            'qtd_vaga' => 'required|integer',
            'qtd_vagas_preenchidas' => 'integer',
            'modalidade_da_vaga' => 'required|string|max:255',
            'id_empresas' => 'required|integer|exists:App\Models\Empresa,id_pessoas',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
                
            return response()->json([
                'error' => $validator->errors()
            ], 422);
                
        }

        if ($request->data_criacao > $request->data_fechamento){

            return response()->json([
                'mensagem' => 'Data de fechamento não pode ser antes da data de criação.'
            ], 200);

        }

        $vaga = new Vaga;

        $vaga->titulo_vaga = $request->titulo_vaga;
        $vaga->descricao = $request->descricao;
        $vaga->salario = $request->salario;
        $vaga->status = $request->status;
        $vaga->data_criacao = Carbon::createFromFormat('d/m/Y', $request->data_criacao)->format('Y-m-d');
        $vaga->data_fechamento = Carbon::createFromFormat('d/m/Y', $request->data_fechamento)->format('Y-m-d');
        $vaga->qtd_vaga = $request->qtd_vaga;
        $vaga->qtd_vagas_preenchidas = 0; //como a vaga está sendo criada, ela vai sempre estar zerada.
        $vaga->modalidade_da_vaga = $request->modalidade_da_vaga;
        $vaga->id_empresas = $request->id_empresas;

        $vaga->save();

        return response()->json([
            'mensagem' => 'Vaga criada com sucesso',
            'data' => $vaga
        ], 200);
    }
        
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vaga = Vaga::find($id);

        if (!$vaga) {
            return response()->json([
                'mensage' => 'Vaga não encontrada'
            ], 404);
        }

        return response()->json($vaga, 200);
    }
    
    public function showAll(){
        
        $vagas = Vaga::all();

        return response()->json([
            'data - todas vagas' => $vagas
            
        ], 200); 

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $vaga = Vaga::find($id);

        if (!$vaga) {
            return response()->json([
                'mensage' => 'Vaga não encontrada'
            ], 404);
        }

        $rules = [

            'titulo_vaga' => 'required|string|max:255',
            'descricao' => 'string|max:255',
            'salario' => 'required|decimal:2',
            'status' => 'string|max:255',
            'data_criacao' => 'required|date',
            'data_fechamento' => 'required|date',
            'qtd_vaga' => 'required|integer',
            'qtd_vagas_preenchidas' => 'integer',
            'modalidade_da_vaga' => 'required|string|max:255',
            'id_empresas' => 'required|integer|exists:App\Models\Empresa,id_pessoas',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            
            return response()->json([
                'error' => $validator->errors()
            ], 422);
            
        }

        if ($request->data_criacao > $request->data_fechamento){

            return response()->json([
                'mensagem' => 'Data de fechamento não pode ser antes da data de criação.'
            ], 200);

        }


        $vaga->titulo_vaga = $request->titulo_vaga;
        $vaga->descricao = $request->descricao;
        $vaga->salario = $request->salario;
        $vaga->status = $request->status;
        $vaga->data_criacao = Carbon::createFromFormat('d/m/Y', $request->data_criacao)->format('Y-m-d');
        $vaga->data_fechamento = Carbon::createFromFormat('d/m/Y', $request->data_fechamento)->format('Y-m-d');
        $vaga->qtd_vaga = $request->qtd_vaga;
        $vaga->qtd_vagas_preenchidas = $request->qtd_vagas_preenchidas;
        $vaga->modalidade_da_vaga = $request->modalidade_da_vaga;
        $vaga->id_empresas = $request->id_empresas;

        $vaga->save();

        return response()->json([
            'mensage' => 'Vaga atualizada com sucesso',
            'data' => $vaga
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vaga = Vaga::find($id);

        if (!$vaga) {
            return response()->json([
                'mensage' => 'Vaga não encontrada'
            ], 404);
        }

        $vaga->vagaOnHabilidade()->detach();
        $vaga->candidato()->detach();

        $vaga->delete();

        return response()->json([
            'mensage' => 'Vaga deletada com sucesso'
        ], 200);
    }

    public function adicionarHabilidades($id_habilidades, $id_vagas){

        $habilidade = Habilidade::find($id_habilidades);
        
        $habilidade->habilidadeOnVaga()->attach($id_vagas);

        $vaga = Vaga::find($id_vagas);

        return response()->json([
            'mensagem' => 'Habilidade colocada na vaga com sucesso!',
            'data - habilidade' => $habilidade,
            'data - vaga' => $vaga
        ], 200); 

    }

    public function verHabilidades($id_vagas){

        $vagas = Vaga::find($id_vagas);
        $habilidades = $vagas->vagaOnHabilidade;
        $nome_habilidades = $habilidades->makeHidden(['id_habilidades', 'status', 'pivot', 'created_at', 'deleted_at','updated_at']);

        return response()->json([
            'data - vaga' => $vagas
            //'data - habilidades' => $nome_habilidades caso precise num futuro próximo
            
        ], 200); 


    }

    public function candidatarPessoas($id_pessoas, $id_vagas){

        $pessoasFisica = PessoasFisica::find($id_pessoas);
        
        $pessoasFisica->candidato()->attach($id_vagas, array('created_at' => Carbon::now(),'updated_at'=> Carbon::now()));

        // $dataCandidatura = $pessoasFisica->candidato()::findOrFail($id_vagas);

        // $dataCandidatura->data_candidatura = $request->data_candidatura;

        // $dataCandidatura->save();

        $vaga = Vaga::find($id_vagas);

        return response()->json([
            'mensagem' => 'Candidato cadastrado na vaga com sucesso!',
            'data - pessoa física' => $pessoasFisica,
            'data - vaga' => $vaga
        ], 200); 

    }

    public function verCandidatos($id_vagas)
{
    $vagas = Vaga::findOrFail($id_vagas);
    $candidatos = $vagas->candidato;

    $pessoas = [];

    foreach ($candidatos as $candidato) {
        // Get Pessoa with pessoasFisica relationship
        $pessoa = Pessoa::with('pessoasFisica')
            ->find($candidato->id_pessoas);

        if ($pessoa) {
            $pessoas[] = $pessoa;
        }
    }

    return response()->json([
        'data' => $pessoas
    ], 200);
}
}
