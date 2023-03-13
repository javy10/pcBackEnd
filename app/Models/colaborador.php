<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colaborador extends Model
{
    use HasFactory;
    protected $fillable = [
        'habilitado'
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
}
