<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'calificacionMinima',
        'intentos',
        'cantidadPreguntas',
        'habilitado',
    ];


}
