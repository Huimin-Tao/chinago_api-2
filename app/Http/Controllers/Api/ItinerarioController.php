<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Itinerario;
use App\Models\Ruta;


class ItinerarioController extends Controller
{
    // Obtener todos los itinerarios de una ruta
    public function index($idRuta)
    {
        $itinerarios = Itinerario::where('id_ruta', $idRuta)->orderBy('num_dia')->get();
        return response()->json($itinerarios);
    }

    // Crear un nuevo itinerario para una ruta
    public function store(Request $request, $idRuta)
    {
        $request->validate([
            'url_icono' => 'required|string',
            'num_dia' => 'required|integer',
            'resumen_itinerario' => 'required|string',
        ]);

        $ruta = Ruta::find($idRuta);
        if (!$ruta) {
            return response()->json(['error' => 'Ruta no encontrada'], 404);
        }

        $itinerario = Itinerario::create([
            'id_ruta' => $idRuta,
            'url_icono' => $request->url_icono,
            'num_dia' => $request->num_dia,
            'resumen_itinerario' => $request->resumen_itinerario,
        ]);

        return response()->json($itinerario, 201);
    }


     // Actualizar un itinerario existente
     public function update(Request $request, $id)
     {
         $itinerario = Itinerario::find($id);
         if (!$itinerario) {
             return response()->json(['error' => 'Itinerario no encontrado'], 404);
         }

         $itinerario->update($request->only([
            'url_icono',
            'num_dia',
            'resumen_itinerario'
        ]));

         return response()->json($itinerario);
     }


    // Eliminar un itinerario
    public function destroy($id)
    {
        $itinerario = Itinerario::find($id);
        if (!$itinerario) {
            return response()->json(['error' => 'Itinerario no encontrado'], 404);
        }

        $itinerario->delete();

        return response()->json(['mensaje' => 'Itinerario eliminado con éxito']);
    }

}
