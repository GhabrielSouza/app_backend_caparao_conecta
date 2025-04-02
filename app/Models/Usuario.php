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

    protected $primaryKey = 'id_usuarios';
    public $timestamps = false;
}
