<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePermiso extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_id',
        'permiso_id',
        'departamento_id',
        'habilitado'
    ];

    public function Colaborador(){
        return $this->belongsTo(User::class);
    }
    public function Departamento(){
        return $this->belongsTo(Departamento::class);
    }
    public function Permiso(){
        return $this->belongsTo(Permiso::class);
    }
}
