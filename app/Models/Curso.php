<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'curso',
        'id_cursos',
        'cargo_horaria',

    ];

    protected $primaryKey = 'id_cursos';

    protected $foreingKey = 'id_cursos';

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class, 'id_instituicoes', 'id_instituicoes');
    }

    public function tipoDeCurso()
    {
        return $this->belongsTo(TipoDeCurso::class, 'id_tipo_de_cursos', 'id_tipo_de_cursos');
    }

    public function cursosOnPessoasFisicas()
    {
        return $this->belongsToMany('App\Models\PessoasFisica', 'pessoas_fisicas_cursos', 'id_cursos', 'id_pessoasFisicas')->withTimestamps();
    }

    public function curso()
    {
        return $this->belongsToMany('App\Models\Vaga', 'vagas_cursos', 'id_cursos', 'id_vagas')->withTimestamps();
    }
}
