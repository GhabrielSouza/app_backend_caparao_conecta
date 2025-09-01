<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'id_pessoas',
        'nome',
        'telefone',
        'sobre',
        'imagem'
    ];

    protected $primaryKey = 'id_pessoas';

    public $autoincrement = true;

    public function empresa()
    { // Relação um pra um de pessoa com empresa
        return $this->hasOne('App\Models\Empresa', 'id_pessoas', 'id_pessoas');
    }

    public function pessoasFisica()
    {
        return $this->hasOne('App\Models\PessoasFisica', 'id_pessoas', 'id_pessoas');
    }

    public function usuario()
    { // Relação um pra um de pessoa com usuário
        return $this->hasOne('App\Models\Usuario', 'id_pessoas', 'id_pessoas');
    }
    public function endereco()
    { // uma pessoa tem N endereços
        return $this->hasOne('App\Models\Endereco', 'id_pessoas', 'id_pessoas');
    }

    public function redeSocial()
    { // uma pessoa tem N endereços
        return $this->hasOne('App\Models\Rede_Social', 'id_pessoas', 'id_pessoas');
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'id_pessoas_destinatario', 'id_pessoas');
    }
}
