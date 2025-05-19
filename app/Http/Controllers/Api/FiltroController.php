<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filtro;

class FiltroController extends Controller
{
    public function show($id)
    {
        $filtro = Filtro::with(['tipoFiltro', 'rutas'])
                        ->findOrFail($id);

        return response()->json($filtro);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tipo'          => 'required|exists:tipo_filtro,id_tipo',
            'contenido_filtro' => 'required|string|max:255',
        ]);

        // Prevenir duplicados
        $exists = Filtro::where('id_tipo', $request->id_tipo)
                        ->where('contenido_filtro', $request->contenido_filtro)
                        ->exists();

        if ($exists) {
            return response()->json([
                'error' => 'Este filtro ya existe'
            ], 409);
        }

        $filtro = Filtro::create([
            'id_tipo'          => $request->id_tipo,
            'contenido_filtro' => $request->contenido_filtro,
        ]);

        return response()->json($filtro, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'contenido_filtro' => 'required|string|max:255',
        ]);

        $filtro = Filtro::findOrFail($id);
        $filtro->contenido_filtro = $request->contenido_filtro;
        $filtro->save();

        return response()->json($filtro);
    }


    public function destroy($id)
    {
        $filtro = Filtro::findOrFail($id);

        // Desasociar antes de eliminar para evitar restricciones
        if ($filtro->rutas()->exists()) {
            $filtro->rutas()->detach();
        }

        $filtro->delete();

        return response()->json(['mensaje' => 'Filtro eliminado con éxito']);
    }
}
