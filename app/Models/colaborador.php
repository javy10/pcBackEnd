<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Colaborador extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $fillable = [
        'habilitado',
        'nombres',
        'apellidos',
        'dui',
        'telefono',
        'clave',
        'correo',
        'agencia_id',
        'departamento_id',
        'cargo_id',
        'foto',
        'intentos'
    ];

    public function agencia(){ //$colaborador->agencia->nombre
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
}
