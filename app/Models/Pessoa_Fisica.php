<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa_Fisica extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'cpf',
        'id_pessoas',
        'data_de_nascimento',
        'sobrenome'
    ];

    protected $primaryKey = 'id_pessoas';

    public function pessoa(){
        return $this->belongsTo('App\Models\Pessoa');
    }

}
