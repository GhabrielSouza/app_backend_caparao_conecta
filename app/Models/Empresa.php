<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'cnpj',
        'id_pessoas',
    ];

    protected $primaryKey = 'id_empresa';
    public $timestamps = false;
}
