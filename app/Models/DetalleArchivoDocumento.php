<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleArchivoDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento_id',
        'descripcion',
        'lectura',
        'fechaLimite',
        'habilitado',
        'nombreArchivo',
        'urlArchivo',
        'disponible'
    ];

    public function Documento(){
        return $this->belongsTo(Documento::class);
    }
}
