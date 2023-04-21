<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'documento_id',
        'tipoPermiso_id',
        'habilitado'
    ];

    public function TipoPermiso(){
        return $this->belongsTo(TipoPermiso::class);
    }
    public function Documento(){
        return $this->belongsTo(Documento::class);
    }
}
