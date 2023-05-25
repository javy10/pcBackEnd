<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGrupoEvaluaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'evaluacion_id',
        'colaborador_id',
        'habilitado',
    ];

    public function Grupo(){
        return $this->belongsTo(GrupoEvaluaciones::class);
    }
    public function Evaluacion(){
        return $this->belongsTo(Evaluaciones::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }

}
