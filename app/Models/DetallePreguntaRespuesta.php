<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePreguntaRespuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregunta_id',
        'respuesta_id',
        'habilitado'
    ];

    public function Pregunta(){
        return $this->belongsTo(Pregunta::class);
    }
    public function Respuesta(){
        return $this->belongsTo(Respuesta::class);
    }
}
