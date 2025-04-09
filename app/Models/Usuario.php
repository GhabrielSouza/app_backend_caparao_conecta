<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'email',
        'senha',
        'id_tipo_usuarios',
        'id_pessoas',
    ];

    protected $primaryKey = 'id_pessoas';

    public $timestamps = false;


    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa');
    }

}
