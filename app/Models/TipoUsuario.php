<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $fillable = [
        'id_tipo_usuarios',
        'nome',
    ];

    protected $primaryKey = 'id_tipo_usuarios';

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_tipo_usuarios', 'id_tipo_usuarios');
    }
}
