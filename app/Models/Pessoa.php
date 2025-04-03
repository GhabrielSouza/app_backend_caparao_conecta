<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = [
        'id_pessoas',
        'nome',
        'telefone',
        'sobre',
        'imagem'
    ];

    protected $primaryKey = 'id_pessoas';
    public $timestamps = false;

    public function empresa(){ // Relação um pra um de pessoa com empresa
        return $this->hasOne('App\Models\Empresa');
    }

    public function usuario(){ // Relação um pra um de pessoa com usuário
        return $this->hasOne('App\Models\Usuario');
    }
}
