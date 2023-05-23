<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsEntradaSalida extends Model
{
    use HasFactory;
    protected $fillable = [
        'colaborador_id',
        'fechaEntrada',
        'fechaSalida',
        'habilitado',
        
    ];

    public function User(){
        return $this->hasMany(User::class);
    }
}
