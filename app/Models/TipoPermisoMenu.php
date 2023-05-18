<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPermisoMenu extends Model
{
    use HasFactory;

    public function PermisoMenu(){
        return $this->hasMany(PermisoMenu::class);
    }
}
