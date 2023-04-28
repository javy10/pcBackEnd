<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluacion_id',
        'nombre',
        'apertura',
        'cierre',
        'habilitado',        
    ];
    
    public function Evaluacion(){
        return $this->belongsTo(Evaluacion::class);
    }
}
