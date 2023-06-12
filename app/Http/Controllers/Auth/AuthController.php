<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    public function register(Request $request)
    {

        $file = $request->file('foto');
        $fileName = $file->getClientOriginalName();
        //echo $fileName;
        $filePath = public_path($fileName);
        $path = $file->storeAs('public/imagenes', $fileName);

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
            'foto' => $fileName,

        ]);
        $token = JWTAuth::fromUser($user);
         
         return response()->json([
            'message' => 'Registrado con exito',
            'user' => $user,
            'token' => $token,
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

    // public function sendResetLinkEmail(Request $request)
    // {
    //     return $request;
    //     die;

    //     $request->validate(['correo' => 'required|email']);

    //     $response = Password::sendResetLink($request->only('correo'));

    //     return $response === Password::RESET_LINK_SENT
    //         ? response()->json(['message' => 'Mensaje enviado'], 200)
    //         : response()->json(['message' => 'Falló el envio del mensaje'], 500);
    // }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // return $request;
        // die;

        $response = $this->broker()->sendResetLink(
            $request->only('correo')
        );

        return $response == Password::RESET_LINK_SENT
                    ? response()->json(['message' => 'Reset password email sent'], 200)
                    : response()->json(['error' => 'Unable to send reset password email'], 500);
    }

    





}
