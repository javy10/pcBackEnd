<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'valorPregunta',
        'tipoPregunta_id',
        'habilitado'
    ];

    public function TipoPregunta(){
        return $this->belongsTo(TipoPregunta::class);
    }
}
