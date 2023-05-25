<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoEvaluaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cierre',
        'apertura',
        'habilitado',
        
    ];
}
