<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PessoasFisica;

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
    /*public function update(Request $request, string $id_pessoas)
    {
        
        $empresa = Empresa::findOrFail($id_pessoas);

        $empresa->cnpj = $request->cnpj;

        $empresa->save();

        return $empresa;

    }

    /**
     * Remove the specified resource from storage.
     
    public function destroy(string $id_pessoas)
    {

    } */
}
