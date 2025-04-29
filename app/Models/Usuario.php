<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'id_tipo_usuarios',
        'id_pessoas',
    ];

    protected $primaryKey = 'id_pessoas';

    public $timestamps = false;


    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa');
    }

}
