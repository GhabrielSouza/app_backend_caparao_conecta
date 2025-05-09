<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\PessoasFisica;

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
        $curso->nome = $request->nome;
        $curso->cargo_horaria = $request->cargo_horaria;

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
