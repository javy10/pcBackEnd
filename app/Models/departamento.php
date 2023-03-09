<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departamento extends Model
{
    public function departamentoCargo()
    {
        return $this->belongsToMany(cargo::class);
    }
}
