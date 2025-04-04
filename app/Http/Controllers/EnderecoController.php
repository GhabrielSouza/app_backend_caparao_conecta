<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Endereco;
use App\Models\Pessoa;
use App\Models\Cidade;

class EnderecoController extends Controller
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

        /*
            Estilo de envio dos dados

            "cep": "aaaaa",
            "id_cidades": 1,
            "bairro": "Lot Nasc",
            "id_pessoas": 6,
            "estado": "São Paulo"

        */

        $endereco = new Endereco;

        $endereco->fill($request->all());

        $endereco->save();

        return response()->json([
            'mensagem' => 'Endereço cadastrado com sucesso',
            'data - Endereço' => $endereco
            
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_enderecos)
    {
        $endereco = Endereco::find($id_enderecos);
        $cidade = Cidade::where('id_cidades', $endereco->id_cidades)->first()->toArray();
        $pessoa = Pessoa::where('id_pessoas', $endereco->id_pessoas)->first()->toArray();
        
        return response()->json([
            'data - Endereço' => $endereco,
            'data - Cidade' => $cidade,
            'data - Pessoa' => $pessoa
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_endereco)
    {
        
        $endereco = Endereco::findOrFail($id_endereco);

        $endereco->fill($request->all());

        $endereco->save();

        return response()->json([
            'mensage' => 'Dados do endereço foram atualizados com sucesso',
            'data - pessoa' => $endereco
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_enderecos)
    {
        
        Endereco::findOrFail( $id_enderecos)->delete();

        return response()->json([
            'mensagem' => 'Endereço deletado com sucesso',
        ], 200);

    }
}
