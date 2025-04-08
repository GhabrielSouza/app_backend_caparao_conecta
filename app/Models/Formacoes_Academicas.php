<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formacoes_Academicas extends Model
{

    protected $table = 'formacoes_academicas';
    protected $primaryKey = 'id_formacoes_academicas';

    public $timestamps = false;
    protected $fillable = [
        'id_formacoes_academicas',
        'escolaridade',
        'area_de_estudo',
        'diploma_formacao',
        'conclusao_formacao',
        'data_emissao',
        'data_conclusao',
        'id_pessoasFisicas',
        'id_instituicoes'
    ];
}
