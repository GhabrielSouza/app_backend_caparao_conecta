<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $filable = [
        'id-vagas',
        'titulo_vaga',
        'descricao',
        'salario',
        'status',
        'data_criacao',
        'data_fechamento',
        'qtd_vaga',
        'requisitos',
        'imagem',
        'qtd_vagas_preenchidas',
        'modalidade_da_vaga',
        'termo_de_prazo',
        'id_empresa',
    ];

    protected $primaryKey = 'id_vagas';
    public $timestamps = false;
}
