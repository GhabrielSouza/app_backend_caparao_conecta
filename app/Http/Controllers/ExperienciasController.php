<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExperienciasController extends Controller
{
    public function index(){
        return view("experiencias.index");
    }
}
