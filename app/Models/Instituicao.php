<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instituicao extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_instituicao',
        'nome',
        'id_cidades',

    ];

    protected $table = 'instituicoes';

    protected $primaryKey = 'id_instituicoes';

    protected $foreingKey = 'id_instituicoes';

    public function formacaoAcademica(){
        return $this->hasMany('App/Models/Formacao_Academica', 'id_instituicoes', 'id_instituicoes');
    }

    public function curso()
    {
        return $this->hasMany('App\Models\Curso', 'id_instituicoes', 'id_instituicoes');
    }

}
