<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'habilitado',
        'nombres',
        'apellidos',
        'dui',
        'telefono',
        'password',
        'email',
        'agencia_id',
        'departamento_id',
        'cargo_id',
        'foto',
        'intentos'
    ];

    public function agencia(){ //$user->agencia->nombre
        return $this->belongsTo(agencia::class); //Pertenece a una agencia.
    }

    public function departamento(){
        return $this->belongsTo(departamento::class);
    }

    public function cargo(){
        return $this->belongsTo(cargo::class);
    }
    

    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }

    public function logs()
    {
        return $this->belongsTo(LogsEntradaSalida::class);
    }
}
