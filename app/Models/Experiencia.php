<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    protected $table = 'experiencias';
    protected $primaryKey = 'id_experiencias';
    public $timestamps = false;
    
    protected $fillable = [
        'cargo',
        'nome_empresa',
        'comprovacao',
        'descricao',
        'id_pessoasFisicas'
    ];
}
