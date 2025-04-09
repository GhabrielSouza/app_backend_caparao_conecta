<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'id_enderecos',
        'cep',
        'id_cidades',
        'bairro',
        'endereco',
        'id_pessoas',
        'estado'
    ];

    protected $primaryKey = 'id_enderecos';

    public $autoincrement = true;

    public function pessoas()
    { // uma pessoa tem N endereços
        return $this->belongsTo('App\Models\Pessoa');
    }

    public function cidade()
    { // uma cidade tem N endereços
        return $this->belongsTo('App\Models\Cidade');
    }
}
