<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioController extends Controller
{
    // Registar nuevo usuario
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_user' => 'required|string',
            'lastname_user' => 'required|string',
            'email_user' => 'required|string|email|unique:usuarios,email_user',
            'password_user' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usuario = Usuario::create([
            'name_user' => $request->name_user,
            'lastname_user' => $request->lastname_user,
            'email_user' => $request->email_user,
            'password_user' => Hash::make($request->password_user),
        ]);

        return response()->json(['usuario' => $usuario], 201);
    }

    // Login y generación de token JWT
    public function login(Request $request)
    {
        $credentials = [
            'email_user' => $request->email_user,
            'password' => $request->password_user,
        ];

        $usuario = Usuario::where('email_user', $request->email_user)->first();

        if (!$usuario || !Hash::check($request->password_user, $usuario->password_user)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        $token = JWTAuth::fromUser($usuario);

        return response()->json([
            'token' => $token,
            'usuario' => $usuario,
        ]);
    }

    // Obtener perfil de usuario por ID
    public function show($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    // Actualizar datos de usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->update($request->only(['name_user', 'lastname_user', 'email_user']));

        return response()->json(['mensaje' => 'Usuario actualizado', 'usuario' => $usuario]);
    }
}
