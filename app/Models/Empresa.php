<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'cnpj',
        'id_pessoas',
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_pessoas';

    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa');
    }

    public function vaga()
    {
        return $this->hasMany('App\Models\Vaga');
    }

}
