<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePreguntasRespuestasAbiertas extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluacion_id',
        'pregunta_id',
        'respuesta_id',
        'habilitado'
    ];

    public function Pregunta(){
        return $this->belongsTo(Pregunta::class);
    }
    public function Evaluacion(){
        return $this->belongsTo(Evaluaciones::class);
    }
    public function Respuesta(){
        return $this->belongsTo(Respuesta::class);
    }
}
