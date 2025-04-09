<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experiencia;

class ExperienciaController extends Controller
{
    public function index(){
        return view("experiencias.index");
    }

    public function all(){
        $experiencias = Experiencia::all();
        return response()->json($experiencias);
    }
}
