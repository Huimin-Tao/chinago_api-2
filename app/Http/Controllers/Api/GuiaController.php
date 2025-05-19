<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guia;
use Illuminate\Support\Facades\Storage;

class GuiaController extends Controller
{
    // Listar todos los guías
    public function index()
    {
        $guias = Guia::with('fotos')->get(); // incluye las fotos del guía
        return response()->json($guias);
    }

    // Ver un guía por su ID
    public function show($id)
    {
        $guia = Guia::with('fotos')->find($id);

        if (!$guia) {
            return response()->json(['error' => 'Guía no encontrado'], 404);
        }

        return response()->json($guia);
    }

    // Crear nuevo guía
    public function store(Request $request)
    {
        $request->validate([
            'titulo_guia' => 'required|string',
            'description_guia' => 'nullable|string',
        ]);

        $guia = Guia::create($request->only([
            'titulo_guia',
            'description_guia',
        ]));

        return response()->json($guia, 201);
    }

    // Actualizar guía existente
    public function update(Request $request, $id)
    {
        $guia = Guia::find($id);

        if (!$guia) {
            return response()->json(['error' => 'Guía no encontrado'], 404);
        }

        $guia->update($request->only([
            'titulo_guia',
            'description_guia',
        ]));

        return response()->json($guia);
    }

    // Eliminar guía
    public function destroy($id)
    {
        $guia = Guia::with('fotos')->find($id);

        if (!$guia) {
            return response()->json(['error' => 'Guía no encontrado'], 404);
        }
        // Borrar fotos asociadas (archivos + BD)
        foreach ($guia->fotos as $foto) {
            // Extraer el nombre del archivo desde la URL
            $urlPath = parse_url($foto->url_foto, PHP_URL_PATH);
            $filename = basename($urlPath);
            Storage::delete('public/images/guias/' . $filename);

            $foto->delete();
        }
        $guia->delete();

        return response()->json(['mensaje' => 'Guía eliminado con éxito']);
    }
}
