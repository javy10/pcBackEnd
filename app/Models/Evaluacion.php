<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'calificacionMinima',
        'habilitado',
        'intentos',
        'colaborador_id',
        'nota',
    ];
    public function Colaborador(){
        return $this->belongsTo(User::class);
    }
}
