<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    protected $table = 'filtros';
    protected $primaryKey = 'id_filtro';
    public $timestamps = false;

    protected $fillable = [
        'id_tipo',
        'contenido_filtro'
    ];

    public function tipoFiltro()
    {
        return $this->belongsTo(TipoFiltro::class, 'id_tipo');
    }
    public function rutas()
    {
        return $this->belongsToMany(Ruta::class,'filtro_rutas','id_filtro','id_ruta');
    }

}
