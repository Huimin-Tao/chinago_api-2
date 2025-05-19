<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'rutas';
    protected $primaryKey = 'id_ruta';
    public $timestamps = false;

    protected $fillable = [
        'titulo_ruta', 'description_ruta'
    ];

    public function fotos()
    {
        return $this->hasMany(FotoRuta::class, 'id_ruta');
    }

    public function itinerarios()
    {
        return $this->hasMany(Itinerario::class, 'id_ruta');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_ruta');
    }

    public function filtros()
    {
        return $this->belongsToMany(Filtro::class,'filtro_rutas','id_ruta','id_filtro');
    }

}
