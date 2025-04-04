<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable = [
        'id_cidades',
        'nome_cidade',
        'id_pais'
        
    ];

    protected $primaryKey = 'id_cidades';

    public $autoincrement = true;
    public $timestamps = false;

    public function endereco(){ // uma cidade tem N endereços
        return $this->hasMany('App\Models\Endereco');
    }

    public function pais(){ // um pais tem N cidades
        return $this->belongsTo('App\Models\Pais');
    }
}
