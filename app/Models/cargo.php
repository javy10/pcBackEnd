<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'departamento_id',
        'habilitado',
        'created_at'
    ];

    public function cargoDepartamento()
    {
        return $this->belongsToMany(departamento::class);
    }
}
