<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'nombres' => $request->nombres,
            'correo' => $request->correo,
            'clave' => $request->clave,
            // 'telefono' => $request->telefono,
            // 'apellidos' => $request->apellidos,
            // 'dui' => $request->dui,
            // 'habilitado' => $request->habilitado,
        ]);
        
        $token = JWTAuth::fromUser($user);

         // devolver una respuesta JSON con el nuevo user
         return response()->json([
             'user' => $user,
             'token' => $token,
             'success' => true
         ], 201);
    }
}
