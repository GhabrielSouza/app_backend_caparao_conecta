<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaAtuacao extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'areas_atuacao';


    protected $primaryKey = 'id_areas_atuacao';

    protected $fillable = [
        'nome_area',
    ];

    public function pessoasFisicas()
    {
        return $this->hasMany(PessoasFisica::class, 'id_areas_atuacao', 'id_areas_atuacao');
    }

    public function vagas()
    {
        return $this->hasMany(Vaga::class, 'id_areas_atuacao', 'id_areas_atuacao');
    }
}
