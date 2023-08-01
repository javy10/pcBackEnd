<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigDepartamentocargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_id',
        'departamento_id',
        'cargo_id',
        'habilitado'
    ];

    public function Usuario(){
        return $this->belongsTo(User::class);
    }
}
