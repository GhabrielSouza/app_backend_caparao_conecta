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

    ];
    protected $primaryKey = 'id_institucao';

    protected $foreingKey = 'id_institucao';

    public function pessoaFisica()
    {
        return $this->belongsToMany('App\Models\PessoasFisica', 'pessoas_fisicas_instituicoes', 'id_instituicao', 'id_pessoasFisicas')->withTimestamps();
    }
}
