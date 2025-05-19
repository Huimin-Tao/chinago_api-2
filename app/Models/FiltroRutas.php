<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiltroRutas extends Model
{
    protected $table = 'filtro_rutas';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    // Campos asignables (opcional, pero recomendable)
    protected $fillable = ['id_filtro', 'id_ruta'];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta');
    }

    public function filtro()
    {
        return $this->belongsTo(Ruta::class, 'id_filtro');
    }
}
