<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruta;
use Illuminate\Support\Facades\Storage;

class RutaController extends Controller
{
    // Obtener todas las rutas con relaciones
    public function index()
    {
        $rutas = Ruta::with(['fotos', 'itinerarios', 'comentarios', 'filtros.tipoFiltro'])->get();
        return response()->json($rutas);
    }

    // Obtener una sola ruta por ID con relaciones
    public function show($id)
    {
        $ruta = Ruta::with(['fotos', 'itinerarios', 'comentarios', 'filtros.tipoFiltro'])->find($id);

        if (!$ruta) {
            return response()->json(['error' => 'Ruta no encontrada'], 404);
        }

        return response()->json($ruta);
    }

    // Crear una nueva ruta
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo_ruta' => 'required|string',
            'description_ruta' => 'required|string'
        ]);

        $ruta = Ruta::create($data);

        return response()->json($ruta, 201);
    }


    // Actualizar una ruta existente
    public function update(Request $request, $id)
    {
        $ruta = Ruta::find($id);

        if (!$ruta) {
            return response()->json(['error' => 'Ruta no encontrada'], 404);
        }

        $ruta->update($request->only([
            'titulo_ruta',
            'description_ruta'
        ]));

        return response()->json($ruta);
    }

    // Eliminar una ruta
    public function destroy($id)
    {

        $ruta = Ruta::with(['fotos', 'itinerarios', 'comentarios', 'filtros'])->find($id);

        if (!$ruta) {
            return response()->json(['error' => 'Ruta no encontrada'], 404);
        }
        foreach ($ruta->fotos as $foto) {
            $urlPath = parse_url($foto->url_foto, PHP_URL_PATH);
            $filename = basename($urlPath);
            Storage::delete('public/images/rutas/' . $filename);

            $foto->delete();
        }
        foreach ($ruta->itinerarios as $itinerario) {
            $itinerario->delete();
        }
        foreach ($ruta->comentarios as $comentario) {
            $comentario->delete();
        }

        $ruta->filtros()->detach();

        $ruta->delete();

        return response()->json(['mensaje' => 'Ruta eliminada'], 204);
    }
}
