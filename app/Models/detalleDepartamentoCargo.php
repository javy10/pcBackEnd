<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalleDepartamentoCargo extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'departamento_id',
    //     'cargo_id',
    //     'habilitado'
    // ];
    public function colaborador(){
        return $this->belongsTo(colaborador::class);
    }
   
}
