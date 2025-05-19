<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoGuia extends Model
{

    protected $table = 'foto_guias';
    protected $primaryKey = 'id_foto';
    public $timestamps = false;

    protected $fillable = [
        'id_guia',
        'url_foto',
    ];

    public function guia()
    {
        return $this->belongsTo(Guia::class, 'id_guia');
    }
}
