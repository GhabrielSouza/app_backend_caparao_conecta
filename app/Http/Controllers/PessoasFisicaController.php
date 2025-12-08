<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PessoasFisica;

use App\Models\Habilidade;

class PessoasFisicaController extends Controller
{

    public function adicionarHabilidades(Request $request)
    {

        $pessoa = PessoasFisica::findOrFail($request->id_pessoasFisicas);

        $pessoa->habilidades()->sync($request->id_habilidades);

        return response()->json([
            'success' => true,
            'mensagem' => 'Habilidades vinculadas com sucesso!'
        ], 200);
    }

    public function removerHabilidades(Request $request)
    {
        $pessoa = PessoasFisica::findOrFail($request->id_pessoasFisicas);

        // Verifica se a pessoa tem as habilidades antes de remover
        $habilidadesExistentes = $pessoa->habilidades()
            ->whereIn('id_habilidades', $request->id_habilidades)
            ->pluck('id_habilidades')
            ->toArray();

        if (empty($habilidadesExistentes)) {
            return response()->json([
                'success' => false,
                'mensagem' => 'Nenhuma das habilidades informadas estava vinculada'
            ], 404);
        }

        $pessoa->habilidades()->detach($habilidadesExistentes);

        return response()->json([
            'success' => true,
            'mensagem' => 'Habilidades removidas com sucesso!',
            'habilidades_removidas' => $habilidadesExistentes
        ]);
    }

    public function verHabilidades($id_pessoas)
    {

        $pessoa = PessoasFisica::find($id_pessoas);
        $habilidades = $pessoa->habilidades;
        $nome_habilidades = $habilidades->makeHidden(['status', 'pivot', 'created_at', 'deleted_at', 'updated_at']);

        return response()->json(
            $nome_habilidades
            ,
            200
        );

    }

}
