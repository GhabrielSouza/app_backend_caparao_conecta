<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empresa;

class EmpresaController extends Controller
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
        
        $empresa = new Empresa;

        $empresa->id_pessoas = $request->id_pessoas;
        $empresa->cnpj = $request->cnpj;

        $empresa->save();

        return response()->json([
            'mensage' => 'Empresa cadastrada com sucesso',
            'data' => $empresa
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pessoas)
    {
        
        $empresa = Empresa::findOrFail($id_pessoas);

        return $empresa; //retorna a variável para o controller de pessoas

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pessoas)
    {
        
        $empresa = Empresa::findOrFail($id_pessoas);
        $empresa->cnpj = $request->cnpj;

        $empresa->save();

        return response()->json([
            'mensage' => 'Dados da empresa foram atualizados com sucesso',
            'data' => $empresa
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_pessoas)
    {
        
        Empresa::findOrFail( $id_pessoas )->delete();

        return response()->json([
            'mensage' => 'Empresa deletada com sucesso',
        ], 200);

    }
}
