<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGrupoColaborador extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'colaborador_id',
        'habilitado',        
    ];

    public function Grupo(){
        return $this->belongsTo(Grupo::class);
    }

    public function Colaborador(){
        return $this->belongsTo(User::class);
    }
}
