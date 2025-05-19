<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rede_Social extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'id_redeSociais',
        'id_pessoas',
        'instagram',
        'github',
        'linkedin',
        'curriculo_lattes'
    ];

    protected $primaryKey = 'id_redeSociais';

    protected $table = 'redes_sociais';


    public $timestamps = false;

    public $autoincrement = true;

    public function pessoas()
    { // uma pessoa tem N endereços
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoas', 'id_pessoas');
    }
}
