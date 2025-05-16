<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instituicao extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_instituicao',
        'nome',

    ];
    protected $primaryKey = 'id_institucao';

    protected $foreingKey = 'id_institucao';

}
