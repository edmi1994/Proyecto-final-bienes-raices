<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = "propiedades";
    protected $fillable = [
        'titulo', 'descripcion', 'tipo_id', 'estado','precio_alquiler','precio_venta','url_imagen','estado_id'
    ];
}
