<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'notificacoes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo',
        'titulo',
        'dados',
        'id_pessoas_destinatario',
        'data_leitura',
    ];

    protected $casts = [
        'dados' => 'array',
        'data_leitura' => 'datetime',
    ];

    public function destinatario()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoas_destinatario', 'id_pessoas');
    }
}
