<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluacion_id',
        'valorPregunta',
        'habilitado',        
    ];

    public function Evaluacion(){
        return $this->belongsTo(Evaluacion::class);
    }
}
