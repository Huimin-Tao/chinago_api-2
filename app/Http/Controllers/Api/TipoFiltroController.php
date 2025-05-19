<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoFiltro;

class TipoFiltroController extends Controller
{
    // Listar todos los tipos de filtro
    public function index()
    {
        return TipoFiltro::with('filtros')->get();
    }

    // Mostrar un tipo de filtro por ID
    public function show($id)
    {
        $tipoFiltro = TipoFiltro::with('filtros')->findOrFail($id);
        if(!$tipoFiltro){
            return response()->json(['error' => 'Tipo filtro no encontrada'], 404);
        }

        return response()->json($tipoFiltro);
    }
    // Crear un nuevo tipo de filtro
    public function store(Request $request)
    {
        $request->validate([
            'description_filtro' => 'required|string|max:255',
        ]);

        $tipoFiltro = TipoFiltro::create($request->all());

        return response()->json($tipoFiltro, 201);
    }



    // Actualizar un tipo de filtro
    public function update(Request $request, $id)
    {
        $tipoFiltro = TipoFiltro::findOrFail($id);

        $tipoFiltro->update($request->all());

        return response()->json($tipoFiltro);
    }

    // Eliminar un tipo de filtro
    public function destroy($id)
    {
        $tipoFiltro = TipoFiltro::findOrFail($id);
        $tipoFiltro->delete();

        return response()->json(null, 204);
    }
}
