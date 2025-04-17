<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PessoasFisica extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'cpf',
        'id_pessoas',
        'data_de_nascimento',
        'sobrenome',
        'cad_unico',
        'genero'
    ];

    protected $primaryKey = 'id_pessoas';

    protected $foreingKey = 'id_pessoas';

    public $timestamps = false;

    public function pessoa(){
        return $this->belongsTo('App\Models\Pessoa');
    }

    public function candidato()
    {
        return $this->belongsToMany('App\Models\Vaga', 'candidaturas', 'id_pessoasFisicas', 'id_vagas')->withTimestamps();
    }

    public function habilidades(){
        return $this->belongsToMany('App\Models\Habilidade','pessoas_fisicas_habilidades','id_pessoasFisicas', 'id_habilidades')->withTimestamps();
    }

}
