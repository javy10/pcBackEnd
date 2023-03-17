<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    public function register(Request $request)
    {
        $user = User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'agencia_id' => $request->agencia_id,
            'departamento_id' => $request->departamento_id,
            'cargo_id' => $request->cargo_id,
            'dui' => $request->dui,
            'telefono' => $request->telefono,
            'intentos' => $request->intentos,
            'habilitado' => $request->habilitado,
            'foto' => $request->foto,

        ]);
        //$token = JWTAuth::fromUser($user);
         // devolver una respuesta JSON con el nuevo user
         return response()->json([
            'message' => 'Registrado con exito',
            'user' => $user,
            'success' => true
         ], 201);
    }

    public function responseToken($token) {
        return response()->json([
            'access_token' => $token,
            'type' => 'Bearer',
            'success' => true
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'dui' => 'required|exists:users',
            'password' => 'required'
        ]);

        if(!$token = auth()->attempt($request->all())) {
            return response()->json([
                'dataDB' => 'No autorizado',
                'success' => false
            ]);
        }
        //return $this->responseToken($token);
        return response()->json([
            'dataDB' => $this->responseToken($token),
            'success' => true
        ]);
    }

    public function refresh() {
        //return $this->responseToken(auth()->refresh());
    }
    public function user() {
        return auth()->user();
    }

    public function logout() {
        auth()->logout();
        return response()->json([
            'message' => 'Se desconectó con éxito'
        ]); //
    }


}
