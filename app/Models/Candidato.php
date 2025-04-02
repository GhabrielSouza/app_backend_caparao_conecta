<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $fillable = [
        'id_pessoas',
        'cpf',
        'data_nascimento',
        'sobrenome',
        'cad_unico',
        'genero',
    ];

    protected $primaryKey = 'id_pessoasFisicas';
    public $timestamps = false;

    protected $table = 'pessoas_fisicas';
}
