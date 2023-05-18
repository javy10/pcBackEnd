<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipoDocumento_id',
        'colaborador_id',
        'habilitado',
        
    ];

    public function Colaborador(){
        return $this->belongsTo(User::class);
    }

    public function TipoDocumento(){
        return $this->belongsTo(TipoDocumento::class);
    }

    public function detalle()
    {
        return $this->hasMany(DetalleArchivoDocumento::class);
    }
}
