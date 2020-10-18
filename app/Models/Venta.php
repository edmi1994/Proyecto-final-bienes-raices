<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = "ventas";
    protected $fillable = [
        'id_cliente', 'nombre_cliente', 'nombre_propiedad', 'tipo','precio','estado'
    ];
}
