<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDeCurso extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_tipo_de_cursos',
        'nome',
    ];

    protected $primaryKey = 'id_tipo_de_cursos';

    protected $foreingKey = 'id_tipo_de_cursos';
    public function curso()
    {
        return $this->hasMany('App\Models\Curso', 'id_tipo_de_cursos', 'id_tipo_de_cursos');
    }
}
