<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientePotencial extends Model
{
    protected $table = 'cliente_potencial';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

protected $fillable = [
        'nombre_cliente',
        'apellido_cliente',
        'email_cliente',
        'telefono_cliente',
        'presupuesto',
        'ciudad',
        'num_grupo',
        'hotel',
        'comentario_cliente',
        'estado_peticion'
    ];
}
