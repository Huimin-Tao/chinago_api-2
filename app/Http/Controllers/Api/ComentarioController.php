<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Ruta;
use App\Models\Usuario;

class ComentarioController extends Controller
{
    // Obtener todos los comentarios de una ruta
    public function index($idRuta)
    {
        $comentarios = Comentario::where('id_ruta', $idRuta)
            ->with('usuario') // carga el usuario que hizo el comentario
            ->orderByDesc('id_comentario')
            ->get();

        return response()->json($comentarios);
    }

    // Crear un nuevo comentario para una ruta
    public function store(Request $request, $idRuta)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'comentario' => 'required|string',
            'valoracion' => 'required|numeric|min:1|max:5',
        ]);

        $ruta = Ruta::find($idRuta);
        if (!$ruta) {
            return response()->json(['error' => 'Ruta no encontrada'], 404);
        }

        $comentario = Comentario::create([
            'id_usuario' => $request->id_usuario,
            'id_ruta' => $idRuta,
            'comentario' => $request->comentario,
            'valoracion' => $request->valoracion,
        ]);

        return response()->json($comentario, 201);
    }

    // Eliminar un comentario
    public function destroy($id)
    {
        $comentario = Comentario::find($id);

        if (!$comentario) {
            return response()->json(['error' => 'Comentario no encontrado'], 404);
        }

        $comentario->delete();

        return response()->json(['mensaje' => 'Comentario eliminado con éxito']);
    }
}
