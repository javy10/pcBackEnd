<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colaborador extends Model
{
    use HasFactory;

    public function agencia(){ //$colaborador->agencia->nombre
        return $this->belongsTo(agencia::class); //Pertenece a una agencia.
    }

    public function detalle(){ //$colaborador->detalleDepartamentoCargo->nombre
        return $this->hasMany(detalleDepartamentoCargo::class); //Pertenece a una agencia.
    }
}
