<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluacion_id',
        'colaborador_id',
        'resultado',
        'habilitado'
    ];

    public function Colaborador(){
        return $this->belongsTo(User::class);
    }

    public function Evaluacion(){
        return $this->belongsTo(Evaluaciones::class);
    }

  
}
