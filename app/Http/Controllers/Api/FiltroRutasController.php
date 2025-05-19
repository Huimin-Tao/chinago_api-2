<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filtro;
use App\Models\FiltroRutas;
use App\Models\Ruta;

class FiltroRutasController extends Controller
{
    public function index($filtroId)
    {
        // Carga el filtro con sus rutas

        $filtro = FiltroRutas::with(['ruta','fotos', 'itinerarios', 'comentarios', 'filtros.tipoFiltro','filtro'])
        ->where('id_filtro', $filtroId)
        ->get();
        return response()->json($filtro);
    }

    /**
     * POST /api/filtros/rutas
     * Asocia un filtro a una ruta.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_filtro' => 'required|numeric',
            'id_ruta'   => 'required|numeric',
        ]);

        // 1) Carga los modelos
        $filtro = Filtro::find($request->id_filtro);
        if (!$filtro){
            return response()->json(['error' => 'Filtro no encontrada'], 404);
        }
        $ruta   = Ruta::find($request->id_ruta);
        if(!$ruta){
            return response()->json(['error' => 'Ruta no encontrada'], 404);
        }

        $filtroRuta = FiltroRutas::create([
            'id_filtro'=> $request->id_filtro,
            'id_ruta' => $request->id_ruta,
        ]);
        return response()->json(['message' => 'Asociación creada correctamente'], 201);
    }


    /**
     * DELETE /api/filtros/{id}/rutas/{idr}
     * Desasocia un filtro de una ruta.
     */
    public function destroy($filtroId, $rutaId)
    {
        $filtro = Filtro::findOrFail($filtroId);

        // Verificar que exista la asociación
        if (! $filtro->rutas()->where('rutas.id_ruta', $rutaId)->exists()) {
            return response()->json(['error' => 'Asociación no encontrada'], 404);
        }

        // Eliminar la relación en la tabla pivote
        $filtro->rutas()->detach($rutaId);

        return response()->json(['message' => 'Asociación eliminada'], 200);
    }

}
