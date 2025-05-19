<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guia extends Model
{
    protected $table = 'guias';
    protected $primaryKey = 'id_guia';
    public $timestamps = false;

    protected $fillable = [
        'titulo_guia',
        'description_guia',
    ];

    public function fotos()
    {
        return $this->hasMany(FotoGuia::class, 'id_guia');
    }
}
