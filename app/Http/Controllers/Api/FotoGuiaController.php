<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FotoGuia;
use App\Models\Guia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FotoGuiaController extends Controller
{
    // Obtener todas las fotos de un guía
    public function index($idGuia)
    {
        $fotos = FotoGuia::where('id_guia', $idGuia)->get();
        return response()->json($fotos);
    }

   // Subir nueva foto a un guía
    public function store(Request $request, $idGuia)
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
        $path = $file->storeAs('images/guias', $filename, 'public');

        // Guardar en BD
        $foto = FotoGuia::create([
            'id_guia' => $idGuia,
            'url_foto' => Storage::url($path)
        ]);

        return response()->json($foto, 201);
    }

    // Actualizar una foto
    public function update(Request $request, $idfoto)
    {
        Log::info('Archivos recibidos:', $request->allFiles());

        $foto = FotoGuia::find($idfoto);
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
                Storage::delete('public/images/guias/' . $filename);
            }

            $file = $request->file('file');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '_' . time()
                    . '.' . $file->extension();
            $path = $file->storeAs('images/guias', $filename, 'public');

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

    // Eliminar una foto de guía
    public function destroy($id)
    {
        $foto = FotoGuia::find($id);

        if (!$foto) {
            return response()->json(['error' => 'Foto no encontrada'], 404);
        }

        if ($foto->url_foto) {
            Storage::delete('public/images/guias/' . $foto->url_foto);
        }

        $foto->delete();

        return response()->json(['mensaje' => 'Foto eliminada con éxito']);
    }
}
