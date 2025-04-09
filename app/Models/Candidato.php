<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidato extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_pessoas',
        'cpf',
        'data_nascimento',
        'sobrenome',
        'cad_unico',
        'genero',
    ];

    protected $primaryKey = 'id_pessoasFisicas';

    protected $table = 'pessoas_fisicas';
}
