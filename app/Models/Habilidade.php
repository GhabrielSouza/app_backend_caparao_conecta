<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Habilidade extends Model
{
    protected $fillable = [
        'id_habilidades',
        'nome',
        'status'
    ];

    protected $primaryKey = 'id_habilidades';
    public $timestamps = false;

}
