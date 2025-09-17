<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\PessoasFisica;
use App\Models\Vaga;
use Carbon\Carbon;
class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        $cursos = Curso::with(['instituicao:id_instituicoes,nome', 'tipoDeCurso:id_tipo_de_cursos,nome'])
            ->paginate($perPage);


        return response()->json($cursos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $curso = new Curso;
        $curso->curso = $request->curso;
        $curso->cargo_horaria = $request->cargo_horaria;
        $curso->status = 'Ativo';
        $curso->link = $request->link;
        $curso->id_tipo_de_cursos = $request->id_tipo_de_cursos;
        $curso->id_instituicoes = $request->id_instituicoes;
        $curso->save();

        return response()->json([
            'curso' => $curso,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $curso = Curso::find($id);

        if (!$curso) {
            return response()->json([
                'message' => 'Curso não encontrado',
            ], 404);
        }

        return response()->json($curso, 200);

    }

    public function showAll()
    {

        $cursos = Curso::all();

        return response()->json(
            $cursos,
            200
        );

    }

    public function adicionarCurso(Request $request)
    {
        $curso = Curso::find($request->id_cursos);

        if (!$curso) {
            return response()->json([
                'message' => 'Curso não encontrado',
            ], 404);
        }

        $pessoa_fisica = PessoasFisica::find($request->id_pessoasFisicas);

        if (!$pessoa_fisica) {
            return response()->json([
                'message' => 'Pessoa física não encontrada',
            ], 404);
        }

        $pessoa_fisica->cursos()->attach($curso->id_cursos, [
            'certificado_curso' => $request->certificado_curso,
            'data_conclusao' => $request->data_conclusao,
        ]);

        return response()->json([
            'message' => 'Curso adicionado com sucesso',
            $pessoa_fisica,
            $curso
        ], 200);
    }
    public function verCursos(string $id_pessoas)
    {
        $pessoa_fisica = PessoasFisica::with('cursos')->find($id_pessoas);

        if (!$pessoa_fisica) {
            return response()->json([
                'message' => 'Pessoa física não encontrada',
            ], 404);
        }

        $cursos = $pessoa_fisica->cursos->makeHidden([
            'created_at',
            'updated_at',
            'deleted_at',
        ]);

        return response()->json($cursos, 200);
    }

    public function listarPorInstituicao($idInstituicao)
    {
        $cursos = Curso::where('id_instituicoes', $idInstituicao)->get();

        return response()->json($cursos);
    }

    public function updateCurso(Request $request, string $id_cursos)
    {
        $curso = Curso::find($id_cursos);

        if (!$curso) {
            return response()->json([
                'message' => 'Curso não encontrado',
            ], 404);
        }

        $pessoa_fisica = PessoasFisica::find($request->id_pessoasFisicas);

        if (!$pessoa_fisica) {
            return response()->json([
                'message' => 'Pessoa física não encontrada',
            ], 404);
        }

        $pessoa_fisica->cursosOnPessoasFisicas()->updateExistingPivot($curso->id_cursos, [
            'certificado_curso' => $request->certificado_curso,
            'data_conclusao' => $request->data_conclusao
        ]);

        return response()->json([
            'message' => 'Curso atualizado com sucesso',
        ], 200);
    }

    public function removerCurso(string $id_cursos, string $id_pessoas)
    {
        $curso = Curso::find($id_cursos);

        if (!$curso) {
            return response()->json([
                'message' => 'Curso não encontrado',
            ], 404);
        }

        $pessoa_fisica = PessoasFisica::find($id_pessoas);

        if (!$pessoa_fisica) {
            return response()->json([
                'message' => 'Pessoa física não encontrada',
            ], 404);
        }

        $pessoa_fisica->cursos()->detach($curso->id);

        return response()->json([
            'message' => 'Curso removido com sucesso',
        ], 200);
    }
    public function adicionarCursoVaga(string $id_cursos, string $id_vagas)
    {
        $curso = Curso::find($id_cursos);

        if (!$curso) {
            return response()->json([
                'message' => 'Curso não encontrado',
            ], 404);
        }

        $vaga = Vaga::find($id_vagas);

        if (!$vaga) {
            return response()->json([
                'message' => 'Vaga não encontrada',
            ], 404);
        }

        $vaga->cursoOnVaga()->attach($curso->id_cursos);

        return response()->json([
            'message' => 'Curso adicionado com sucesso',
        ], 200);
    }
    public function verCursosVaga(string $id_vagas)
    {
        $vaga = Vaga::find($id_vagas);

        if (!$vaga) {
            return response()->json([
                'message' => 'Vaga não encontrada',
            ], 404);
        }

        return response()->json($vaga->cursoOnVaga, 200);
    }

    public function removerCursoVaga(string $id_cursos, string $id_vagas)
    {
        $curso = Curso::find($id_cursos);

        if (!$curso) {
            return response()->json([
                'message' => 'Curso não encontrado',
            ], 404);
        }

        $vaga = Vaga::find($id_vagas);

        if (!$vaga) {
            return response()->json([
                'message' => 'Vaga não encontrada',
            ], 404);
        }

        $vaga->cursoOnVaga()->detach($curso->id_cursos);

        return response()->json([
            'message' => 'Curso removido com sucesso',
        ], 200);
    }

    public function toggleStatus($id)
    {
        $curso = Curso::findOrFail($id);

        $novoStatus = $curso->status == 'Ativo' ? 'Inativo' : 'Ativo';

        $curso->status = $novoStatus;
        $curso->save();

        $mensagem = "Beneficiário " . ($novoStatus == 'Ativo' ? 'Ativado' : 'Inativado') . " com sucesso!";

        return response()->json($mensagem, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $curso = Curso::find($id);

        if (!$curso) {
            return response()->json([
                'message' => 'Curso não encontrado',
            ], 404);
        }

        $curso->curso = $request->curso;
        $curso->cargo_horaria = $request->cargo_horaria;
        $curso->status = 'Ativo';
        $curso->link = $request->link;
        $curso->id_tipo_de_cursos = $request->id_tipo_de_cursos;
        $curso->id_instituicoes = $request->id_instituicoes;
        $curso->save();

        return response()->json($curso, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $curso = Curso::find($id);

        if (!$curso) {
            return response()->json([
                'message' => 'Curso não encontrado',
            ], 404);
        }

        $curso->delete();

        return response()->json([
            'message' => 'Curso deletado com sucesso',
        ], 200);

    }
}
