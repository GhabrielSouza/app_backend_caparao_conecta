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
        'id_areas_atuacao'
    ];

    protected $primaryKey = 'id_vagas';



    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa', 'id_empresas', 'id_pessoas');
    }

    public function areaAtuacao()
    {
        return $this->belongsTo(AreaAtuacao::class, 'id_areas_atuacao', 'id_areas_atuacao');
    }

    public function habilidades()
    {
        return $this->belongsToMany(Habilidade::class, 'vagas_habilidades', 'id_vagas', 'id_habilidades')->withTimestamps();
    }

    public function candidato()
    {
        return $this->belongsToMany('App\Models\PessoasFisica', 'candidaturas', 'id_vagas', 'id_pessoasFisicas')->withPivot('status', 'created_at', 'updated_at')->withTimestamps();
    }

    public function curso()
    {
        return $this->belongsToMany(Curso::class, 'vagas_cursos', 'id_vagas', 'id_cursos')->withTimestamps();
    }
}
