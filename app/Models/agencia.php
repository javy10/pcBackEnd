<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agencia extends Model
{
    use HasFactory;
    
    public function colaborador(){
        return $this->hasMany(colaborador::class);
    }
}
