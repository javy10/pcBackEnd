<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePermisoMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_id',
        'permisoMenu_id',
        'cargo_id',
        'menu_id',
        'departamento_id',
        'habilitado'
    ];

    public function Colaborador(){
        return $this->belongsTo(User::class);
    }
    public function Cargo(){
        return $this->belongsTo(Cargo::class);
    }
    public function PermisoMenu(){
        return $this->belongsTo(PermisoMenu::class);
    }
    public function Menu(){
        return $this->belongsTo(Menu::class);
    }
}
