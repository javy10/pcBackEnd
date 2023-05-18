<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tipoPermisoMenu_id',
        'habilitado'
    ];

    public function TipoPermisoMenu(){
        return $this->belongsTo(TipoPermisoMenu::class);
    }
}
