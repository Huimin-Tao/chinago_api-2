<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientePotencial;

class ClientePotencialController extends Controller
{
    // Listar todos los clientes potenciales
    public function index()
    {
        return ClientePotencial::all();
    }

    // Ver un cliente potencial por ID
    public function show($id)
    {
        $cliente = ClientePotencial::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente potencial no encontrado'], 404);
        }

        return response()->json($cliente);
    }

    // Crear un nuevo cliente potencial
    public function store(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string',
            'apellido_cliente' => 'required|string',
            'email_cliente' => 'required|string|email',
            'telefono_cliente' => 'required|string',
            'presupuesto' => 'required|string',
            'ciudad' => 'required|string',
            'num_grupo' => 'required|string',
            'hotel' => 'required|string',
            'comentario_cliente' => 'required|string',
            'estado_peticion' => 'required|string',
        ]);

        $cliente = ClientePotencial::create([
            'nombre_cliente' => $request->nombre_cliente,
            'apellido_cliente' => $request->apellido_cliente,
            'email_cliente' => $request->email_cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'presupuesto' => $request->presupuesto,
            'ciudad' => $request->ciudad,
            'num_grupo' => $request->num_grupo,
            'hotel' => $request->hotel,
            'comentario_cliente' => $request->comentario_cliente,
            'estado_peticion' => $request->estado_peticion,
        ]);

        return response()->json($cliente, 201);
    }

    // Actualizar un cliente potencial
    public function update(Request $request, $id)
    {
        $cliente = ClientePotencial::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente potencial no encontrado'], 404);
        }


        $cliente->update($request->only([
            'estado_peticion'
        ]));

        return response()->json($cliente);
    }
}
