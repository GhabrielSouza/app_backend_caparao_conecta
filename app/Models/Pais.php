<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $fillable = [
        'id_pais',
        'nome_pais'
        
    ];

    protected $primaryKey = 'id_pais';

    public $autoincrement = true;
    public $timestamps = false;

    public function cidade(){ // um pais tem N cidades
        return $this->hasMany('App\Models\Cidade');
    }

}
