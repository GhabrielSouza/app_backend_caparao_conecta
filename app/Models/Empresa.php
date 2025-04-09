<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'cnpj',
        'id_pessoas',
    ];

    protected $primaryKey = 'id_pessoas';

    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa');
    }

    public function vaga()
    {
        return $this->hasMany('App\Models\Vaga');
    }

}
