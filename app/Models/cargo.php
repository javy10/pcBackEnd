<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cargo extends Model
{
    public function cargoDepartamento()
    {
        return $this->belongsToMany(departamento::class);
    }
}
