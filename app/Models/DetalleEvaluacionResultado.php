<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEvaluacionResultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregunta_id',
        'respuesta_id',
        'resultado_id',
        'habilitado'
    ];
    public function Pregunta(){
        return $this->belongsTo(Pregunta::class);
    }

    public function Respuesta(){
        return $this->belongsTo(Respuesta::class);
    }

    public function Resultado(){
        return $this->belongsTo(Resultado::class);
    }
}
