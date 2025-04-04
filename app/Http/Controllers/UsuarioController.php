<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $usuario = new Usuario;

        $usuario->id_pessoas = $request->id_pessoas;
        $usuario->email = $request->email;
        $usuario->senha = $request->senha;
        $usuario->id_tipo_usuarios = $request->id_tipo_usuarios;

        $usuario->save();

        return $usuario;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pessoas)
    {
        
        $usuario = Usuario::findOrFail($id_pessoas);

        return $usuario; //retorna a variável para o controller de pessoas
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pessoas)
    {
        
        $usuario = Usuario::findOrFail($id_pessoas);

        $usuario->id_pessoas = $request->id_pessoas;
        $usuario->email = $request->email;
        $usuario->senha = $request->senha;
        $usuario->id_tipo_usuarios = $request->id_tipo_usuarios;

        $usuario->save();

        return $usuario;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
