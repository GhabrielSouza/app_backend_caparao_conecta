<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Habilidade;
use App\Models\Pessoa;
use App\Models\PessoasFisica;
use App\Models\Vaga;
use Carbon\Carbon;
use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

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
        $rules = [
            'titulo_vaga' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'salario' => 'required',
            'data_fechamento' => 'required|date',
            'qtd_vaga' => 'required|integer',
            'modalidade_da_vaga' => 'required|string|max:255',
            'id_empresas' => 'required|integer|exists:empresas,id_pessoas',

            'habilidades' => 'nullable|array',
            'cursos' => 'nullable|array',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // A lógica de criação da vaga permanece a mesma
        $vaga = new Vaga;
        $vaga->titulo_vaga = $request->titulo_vaga;
        $vaga->descricao = $request->descricao;
        $vaga->salario = $request->salario;
        $vaga->status = $request->status;
        $vaga->data_criacao = Carbon::now();
        $vaga->data_fechamento = $request->data_fechamento;
        $vaga->qtd_vaga = $request->qtd_vaga;
        $vaga->qtd_vagas_preenchidas = 0;
        $vaga->modalidade_da_vaga = $request->modalidade_da_vaga;
        $vaga->id_empresas = $request->id_empresas;
        $vaga->save();

        if ($request->has('habilidades')) {
            $vaga->habilidades()->sync($request->habilidades);
        }

        if ($request->has('cursos')) {
            $vaga->curso()->sync($request->cursos);
        }

        return response()->json([
            'mensagem' => 'Vaga, habilidades e cursos cadastrados com sucesso!',
            'data' => $vaga
        ], 201);
    }

    public function adicionarHabilidades($id_habilidades, $id_vagas)
    {

        $habilidade = Habilidade::find($id_habilidades);

        $habilidade->habilidadeOnVaga()->attach($id_vagas);

        $vaga = Vaga::find($id_vagas);

        return response()->json([
            'mensagem' => 'Habilidade colocada na vaga com sucesso!',
            'data - habilidade' => $habilidade,
            'data - vaga' => $vaga
        ], 200);

    }

    public function adicionarCursos($id_vaga, $id_curso)
    {
        $curso = Curso::find($id_curso);

        $curso->cursoOnVaga()->attach($id_vaga);

        $vaga = Vaga::find($id_vaga);

        return response()->json([
            'mensagem' => 'Habilidade colocada na vaga com sucesso!',
            'curso' => $curso,
            'vaga' => $vaga
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vaga = Vaga::with(['habilidades', 'curso', 'empresa.pessoa.redeSocial', 'empresa.pessoa.endereco.cidade'])->find($id);

        if (!$vaga) {
            return response()->json([
                'message' => 'Vaga não encontrada'
            ], 404);
        }


        return response()->json($vaga, 200);
    }

    public function showAll(Request $request)
    {
        $modalidade = $request->input('modalidade') ? explode(",", $request->input('modalidade')) : [];
        $id_empresa = $request->input('id_empresa') ? explode(",", $request->input('id_empresa')) : [];
        $atuacao = $request->input('atuacao') ? explode(",", $request->input('atuacao')) : [];

        $vagas = Vaga::query()
            ->with(['habilidades', 'curso'])
            ->when(!empty($modalidade), function ($query) use ($modalidade) {
                $query->whereIn('modalidade_da_vaga', $modalidade);
            })
            ->when(!empty($id_empresa), function ($query) use ($id_empresa) {
                $query->whereIn('id_empresas', $id_empresa);
            })
            ->when(!empty($atuacao), function ($query) use ($atuacao) {
                $query->whereIn('atuacao', $atuacao);
            })
            ->get();

        return response()->json($vagas, 200);
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
            'descricao' => 'string',
            'salario' => 'required',
            'status' => 'string|max:255',
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

        if ($request->data_criacao > $request->data_fechamento) {

            return response()->json([
                'mensagem' => 'Data de fechamento não pode ser antes da data de criação.'
            ], 200);

        }


        $vaga->titulo_vaga = $request->titulo_vaga;
        $vaga->descricao = $request->descricao;
        $vaga->salario = $request->salario;
        $vaga->status = $request->status;
        $vaga->data_criacao = Carbon::now();
        $vaga->data_fechamento = Carbon::parse($request->input('data_fechamento'));
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

    public function updateStatusFinalizar(string $id)
    {
        $vaga = Vaga::find($id);

        if (!$vaga) {
            return response()->json([
                'mensage' => 'Vaga não encontrada'
            ], 404);
        }

        $vaga->status = 'FINALIZADO';
        $vaga->save();

        return response()->json([
            'mensage' => 'Vaga finalizada com sucesso'
        ], 200);
    }

    public function updateReativar(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:vagas,id_vagas',
            'status' => 'required|string',
        ]);

        Vaga::whereIn('id_vagas', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json(['message' => 'Status das vagas atualizado com sucesso.']);
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

        $vaga->habilidades()->detach();
        $vaga->curso()->detach();

        $vaga->candidato()->detach();

        $vaga->delete();

        return response()->json([
            'mensage' => 'Vaga deletada com sucesso'
        ], 200);
    }





    public function verHabilidades($id_vagas)
    {

        $vagas = Vaga::find($id_vagas);
        $habilidades = $vagas->vagaOnHabilidade;
        $nome_habilidades = $habilidades->makeHidden(['id_habilidades', 'status', 'pivot', 'created_at', 'deleted_at', 'updated_at']);


        return response()->json(
            $vagas,
            200
        );


    }

    public function candidatarPessoas(Request $request, $id_vagas)
    {

        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['message' => 'Não autorizado.'], 401);
        }

        $usuario = Usuario::with('pessoa.pessoasFisica')->find($userId);

        if (!$usuario || !$usuario->pessoa || !$usuario->pessoa->pessoasFisica) {
            return response()->json(['message' => 'Dados de pessoa física não encontrados para este usuário.'], 404);
        }

        $pessoaFisica = $usuario->pessoa->pessoasFisica;

        $vaga = Vaga::findOrFail($id_vagas);

        $pessoaFisica->candidato()->attach($vaga->id_vagas);

        return response()->json([
            'message' => 'Candidatura realizada com sucesso!',
            'vaga' => $vaga
        ], 200);
    }



    public function atualizarStatusCandidato(Request $request, Vaga $vaga, PessoasFisica $pessoaFisica)
    {
        $request->validate([
            'status' => 'required|string|in:Entrevista,Rejeitado,Contratado,Recebido',
        ]);

        $vaga->candidato()->updateExistingPivot($pessoaFisica->id_pessoas, [
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Status do candidato atualizado com sucesso!']);
    }

    public function verCandidatos($id_vagas)
    {
        $vaga = Vaga::with('candidato.pessoa', 'candidato.habilidades', 'candidato.cursos')->findOrFail($id_vagas);

        $candidatos = $vaga->candidato;

        return response()->json($candidatos, 200);
    }
}
