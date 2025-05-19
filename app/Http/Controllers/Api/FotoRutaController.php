<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FotoRuta;
use App\Models\Ruta;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class FotoRutaController extends Controller
{
    // Obtener todas las fotos de una ruta
    public function index($id)
    {
        $fotos = FotoRuta::where('id_ruta', $id)->get();
        return response()->json($fotos);
    }

    // Subir una nueva foto a una ruta
    public function store(Request $request, $id)
    {

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('file');

        // Generar nombre único para evitar colisiones
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '_' . time()
                    . '.' . $file->extension();

        // Almacenar en el disco "public"
        $path = $file->storeAs('images/rutas', $filename, 'public');

        // Guardar en BD
        $foto = FotoRuta::create([
            'id_ruta' => $id,
            'url_foto' => Storage::url($path)
        ]);

        return response()->json($foto, 201);
    }

     // Actualizar una foto (ej: cambiar URL)
     public function update(Request $request, $idfoto)
     {

        $foto = FotoRuta::find($idfoto);
        if (!$foto) {
            return response()->json(['error' => 'Foto no encontrada'], 404);
        }

        $request->validate([
            'file' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {

            if ($foto->url_foto) {
                $urlPath = parse_url($foto->url_foto, PHP_URL_PATH);
                $filename = basename($urlPath);
                Storage::delete('public/images/rutas/' . $filename);
            }

            $file = $request->file('file');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '_' . time()
                    . '.' . $file->extension();
            $path = $file->storeAs('images/rutas', $filename, 'public');

            $foto->url_foto = Storage::url($path);
        }

        elseif ($request->filled('url_foto')) {
            $foto->url_foto = $request->input('url_foto');
        }

        else {
            return response()->json(['error' => 'No se proporcionó imagen ni URL'], 422);
        }

        $foto->save();

        return response()->json([
            'id_foto'  => $foto->id_foto,
            'id_guia'  => $foto->id_guia,
            'url_foto' => $foto->url_foto,
        ]);
     }


    // Eliminar una foto específica de una ruta
    public function destroy($id, $fotoId)
    {
        $foto = FotoRuta::where('id_ruta', $id)->where('id_foto', $fotoId)->first();

        if (!$foto) {
            return response()->json(['error' => 'Foto no encontrada'], 404);
        }

        $foto->delete();

        return response()->json(['mensaje' => 'Foto eliminada con éxito']);
    }
}
