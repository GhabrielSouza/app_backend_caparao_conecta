<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PessoasFisica;

use App\Models\Habilidade;

class PessoasFisicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $pessoa_fisica = new PessoasFisica;

        $pessoa_fisica->cpf = $request->cpf;
        $pessoa_fisica->id_pessoas = $request->id_pessoas;
        $pessoa_fisica->data_de_nascimento = $request->data_de_nascimento;
        $pessoa_fisica->sobrenome = $request->sobrenome;
        $pessoa_fisica->cad_unico = $request->cad_unico;
        $pessoa_fisica->genero = $request->genero;

        $pessoa_fisica->save();

        return $pessoa_fisica;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pessoas)
    {
        
        $pessoa_fisica = PessoasFisica::findOrFail($id_pessoas);

        return $pessoa_fisica; //retorna a variável para o controller de pessoas

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pessoas)
    {
        
        $pessoaFisica = PessoasFisica::findOrFail($id_pessoas);

        $pessoaFisica->cpf = $request->cpf;
        $pessoaFisica->id_pessoas = $request->id_pessoas;
        $pessoaFisica->data_de_nascimento = $request->data_de_nascimento;
        $pessoaFisica->sobrenome = $request->sobrenome;
        $pessoaFisica->cad_unico = $request->cad_unico;
        $pessoaFisica->genero = $request->genero;

        $pessoaFisica->save();

        return $pessoaFisica;

    }

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

    public function verHabilidades($id_pessoas){

        $pessoa = PessoasFisica::find($id_pessoas);
        $habilidades = $pessoa->habilidades;
        $nome_habilidades = $habilidades->makeHidden(['status', 'pivot', 'created_at', 'deleted_at','updated_at']);

        return response()->json(
            $nome_habilidades
            , 200); 

        /*foreach ($vaga->Habilidade as $habilidade) {
            Habilidade::find($habilidade->vagas_habilidades->id_habilidades);
        } */

    }

    /*
     * Remove the specified resource from storage.
     
    public function destroy(string $id_pessoas)
    {
        //vai ter na pessoa, só
    } */
}
