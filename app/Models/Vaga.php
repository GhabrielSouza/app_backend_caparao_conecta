<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaga extends Model
{
    use SoftDeletes;
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



    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function vagaOnHabilidade()
    {
        return $this->belongsToMany('App\Models\Habilidade', 'vagas_habilidades', 'id_vagas', 'id_habilidades')->withTimestamps();
    }

    public function candidato()
    {
        return $this->belongsToMany('App\Models\PessoasFisica', 'candidaturas', 'id_vagas', 'id_pessoasFisicas')->withTimestamps();
    }
}
