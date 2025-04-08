<?php

namespace App\Http\Controllers;

use App\Models\Habilidade;
use App\Models\Vaga;
use Illuminate\Http\Request;

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
            "data_criacao": "2006-07-02",
            "data_fechamento": "2006-07-02",
            "qtd_vaga": 20,
            "qtd_vagas_preenchidas": 12,
            "modalidade_da_vaga": "presencial",
            "id_empresas": 16

        */

        $vaga = new Vaga;

        $vaga->titulo_vaga = $request->titulo_vaga;
        $vaga->descricao = $request->descricao;
        $vaga->salario = $request->salario;
        $vaga->status = $request->status;
        $vaga->data_criacao = $request->data_criacao;
        $vaga->data_fechamento = $request->data_fechamento;
        $vaga->qtd_vaga = $request->qtd_vaga;
        $vaga->qtd_vagas_preenchidas = $request->qtd_vagas_preenchidas;
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $vaga = Vaga::find($id);

        $vaga->titulo_vaga = $request->titulo_vaga;
        $vaga->descricao = $request->descricao;
        $vaga->salario = $request->salario;
        $vaga->status = $request->status;
        $vaga->data_criacao = $request->data_criacao;
        $vaga->data_fechamento = $request->data_fechamento;
        $vaga->qtd_vaga = $request->qtd_vaga;
        $vaga->qtd_vagas_preenchidas = $request->qtd_vagas_preenchidas;
        $vaga->modalidade_da_vaga = $request->modalidade_da_vaga;
        $vaga->id_empresas = $request->id_empresas;

        if (!$vaga) {
            return response()->json([
                'mensage' => 'Vaga não encontrada'
            ], 404);
        }

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
        $nome_habilidades = $habilidades->makeHidden(['id_habilidades', 'status', 'pivot']);

        return response()->json([
            'data - vaga' => $vagas,
            'data - habilidades' => $nome_habilidades
            
        ], 200); 

        /*foreach ($vaga->Habilidade as $habilidade) {
            Habilidade::find($habilidade->vagas_habilidades->id_habilidades);
        } */

    }

}
