<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEvaluacionPregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluacion_id',
        'pregunta_id',
        'nota',
        'habilitado'
    ];

    public function Pregunta(){
        return $this->belongsTo(Pregunta::class);
    }
    public function Evaluacion(){
        return $this->belongsTo(Evaluaciones::class);
    }
}
