<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FotoRuta extends Model
{
    protected $table = 'foto_rutas';
    protected $primaryKey = 'id_foto';
    public $timestamps = false;

    protected $fillable = [
        'id_ruta',
        'url_foto',
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta');
    }
}
