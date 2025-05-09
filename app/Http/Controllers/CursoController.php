<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\PessoasFisica;
use App\Models\Vaga;
class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Curso::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $curso = new Curso;
        $curso->curso = $request->curso;
        $curso->cargo_horaria = $request->cargo_horaria;
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

    public function adicionarCurso(Request $request, string $id_cursos, string $id_pessoas)
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

        $pessoa_fisica->cursos()->attach($curso->id);

        return response()->json([
            'message' => 'Curso adicionado com sucesso',
        ], 200);
    }
    public function verCursos(string $id_pessoas)
    {
        $pessoa_fisica = PessoasFisica::find($id_pessoas);

        if (!$pessoa_fisica) {
            return response()->json([
                'message' => 'Pessoa física não encontrada',
            ], 404);
        }

        return response()->json($pessoa_fisica->cursos, 200);
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
    public function adicionarCursoVaga(Request $request, string $id_cursos, string $id_vagas)
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

        $vaga->cursos()->attach($curso->id);

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

        return response()->json($vaga->cursos, 200);
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

        $vaga->cursos()->detach($curso->id);

        return response()->json([
            'message' => 'Curso removido com sucesso',
        ], 200);
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

        $curso->nome = $request->nome;
        $curso->cargo_horaria = $request->cargo_horaria;
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
