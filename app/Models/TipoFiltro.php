<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFiltro extends Model
{
    protected $table = 'tipo_filtro';
    protected $primaryKey = 'id_tipo';
    public $timestamps = false;

    protected $fillable = [
        'description_filtro',
    ];

    public function filtros()
    {
        return $this->hasMany(Filtro::class, 'id_tipo');
    }
}
