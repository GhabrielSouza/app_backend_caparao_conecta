<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'email',
        'senha',
        'id_tipo_usuarios',
        'id_pessoas',
    ];

    protected $primaryKey = 'id_pessoas';

    public function pessoa(){
        return $this->belongsTo('App\Models\Pessoa');
    }

}
