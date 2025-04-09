<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_pais',
        'nome_pais'
        
    ];

    protected $primaryKey = 'id_pais';

    public $autoincrement = true;

    public function cidade(){ // um pais tem N cidades
        return $this->hasMany('App\Models\Cidade');
    }

}
