<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPasswordNotification;

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
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoas', 'id_pessoas');
    }

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipo_usuarios', 'id_tipo_usuarios');
    }

    public function sendPasswordResetNotification($token)
    {
        // 2. Diz ao Laravel para usar a sua notificação personalizada
        $this->notify(new CustomResetPasswordNotification($token));
    }
}
