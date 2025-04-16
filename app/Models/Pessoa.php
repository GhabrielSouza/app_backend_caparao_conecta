<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'id_pessoas',
        'nome',
        'telefone',
        'sobre',
        'imagem'
    ];

    protected $primaryKey = 'id_pessoas';

    public $autoincrement = true;

    public function empresa()
    { // Relação um pra um de pessoa com empresa
        return $this->hasOne('App\Models\Empresa');
    }

    public function pessoasFisica(){
         return $this->hasOne('App\Models\PessoasFisica', 'id_pessoas', 'id_pessoas'); 
    }

    public function usuario(){ // Relação um pra um de pessoa com usuário
        return $this->hasOne('App\Models\Usuario');
    }
    public function endereco()
    { // uma pessoa tem N endereços
        return $this->hasOne('App\Models\Endereco');
    }
}
