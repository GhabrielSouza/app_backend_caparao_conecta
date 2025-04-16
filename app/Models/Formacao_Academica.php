<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formacao_Academica extends Model
{
    protected $table = 'formacoes_academicas';
    protected $primaryKey = 'id_formacoes_academicas';
    public $timestamps = false;
    
    protected $fillable = [
        'area_de_estudo',
        'conclusao_formacao',
        'data_conclusao',
        'data_emissao',
        'diploma_formacao',
        'escolaridade',
        'id_instituicoes',
        'id_pessoasFisicas'

    ];
}
