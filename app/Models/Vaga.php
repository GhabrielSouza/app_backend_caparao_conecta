<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $filable = [
        'id_vagas',
        'titulo_vaga',
        'descricao',
        'salario',
        'status',
        'data_criacao',
        'data_fechamento',
        'qtd_vaga',
        'qtd_vagas_preenchidas',
        'modalidade_da_vaga',
        'id_empresas',
    ];

    protected $primaryKey = 'id_vagas';
    public $timestamps = false;

    public function empresa(){
        return $this->belongsTo('App\Models\Empresa');
    }
}
