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

    public $timestamps = false;

    protected $primaryKey = 'id_cursos';

    protected $foreingKey = 'id_cursos';

    public function instituicao()
    {
        return $this->belongsTo('App\Models\Curso');
    }

    public function tipoDeCurso(){
        return $this->belongsTo('App\Models\TipoDeCurso');
    }

    public function cursoOnPessoaFisica()
    {
        return $this->belongsToMany('App\Models\PessoasFisica', 'pessoas_fisicas_cursos', 'id_cursos', 'id_pessoasFisicas')->withTimestamps();
    }

    public function cursoOnVaga()
    {
        return $this->belongsToMany('App\Models\Vaga', 'vagas_cursos', 'id_cursos', 'id_vagas')->withTimestamps();
    }
}
