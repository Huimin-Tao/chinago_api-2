<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model
{
    protected $table = 'itinerarios';
    protected $primaryKey = 'id_itinerario';
    public $timestamps = false;

    protected $fillable = [
        'id_ruta',
        'url_icono',
        'num_dia',
        'resumen_itinerario',
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta');
    }
}
