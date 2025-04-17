<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    protected $table = 'experiencias';
    protected $primaryKey = 'id_experiencias';
    use SoftDeletes;
    
    protected $fillable = [
        'cargo',
        'nome_empresa',
        'comprovacao',
        'descricao',
        'id_pessoasFisicas'
    ];
}