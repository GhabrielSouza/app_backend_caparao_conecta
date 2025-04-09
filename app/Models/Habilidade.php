<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habilidade extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_habilidades',
        'nome',
        'status'
    ];

    protected $primaryKey = 'id_habilidades';

    public function habilidadeOnVaga(){
        return $this->belongsToMany('App\Models\Vaga' ,'vagas_habilidades', 'id_habilidades', 'id_vagas');
    }

}
