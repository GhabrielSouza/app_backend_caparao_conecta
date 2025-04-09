<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pessoa_Fisica;

class Pessoa_FisicaController extends Controller
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
        
        $pessoa_fisica = new Pessoa_Fisica;

        $pessoa_fisica->cpf = $request->cpf;
        $pessoa_fisica->id_pessoas = $request->id_pessoas;
        $pessoa_fisica->data_de_nascimento = $request->data_de_nascimento;
        $pessoa_fisica->sobrenome = $request->sobrenome;

        $pessoa_fisica->save();

        return $pessoa_fisica;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pessoas)
    {
        
        $pessoa_fisica = Pessoa_Fisica::findOrFail($id_pessoas);

        return $pessoa_fisica; //retorna a variável para o controller de pessoas

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pessoas)
    {
        
        $empresa = Empresa::findOrFail($id_pessoas);

        $empresa->cnpj = $request->cnpj;

        $empresa->save();

        return $empresa;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_pessoas)
    {

    }
}
