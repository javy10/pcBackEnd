<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Models\User as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class colaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $colaborador = DB::table('users')
                ->select('agencias.nombre AS agencia', 'agencias.id AS agencia_id', 'departamentos.nombre AS departamento', 'departamentos.id AS departamento_id', 'cargos.nombre as cargo', 'cargos.id AS cargo_id', 'users.nombres AS nombres', 'users.apellidos AS apellidos', 'users.telefono AS telefono', 'users.correo AS correo', 'users.dui AS dui', 'users.id AS id', 'users.foto AS foto', 'users.intentos AS intentos')
                ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
                ->join('departamentos', 'users.departamento_id', '=', 'departamentos.id')
                ->join('cargos', 'users.cargo_id', '=', 'cargos.id')
                ->where('users.habilitado', 'S')
                ->get();

        return response()->json([
            'dataDB' => $colaborador,
            'success' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createColaborador(Request $request)
    {

        // return $request;
        // die;
        // obtener los datos del usuario de la solicitud POST
        //  $nombres = $request->input('nombres');
        //  $apellidos = $request->input('apellidos');
        //  $correo = $request->input('correo');
        //  $dui = $request->input('dui');
        //  $clave = $request->input('clave');
        //  $telefono = $request->input('telefono');
        //  $correo = $request->input('correo');
        //  $agencia_id = $request->input('agencia');
        //  $departamento_id = $request->input('departamento');
        //  $cargo_id = $request->input('cargo');
         //$foto = $request->input('foto');

        //  $img = $request->file('foto');
        //  $nombreImg = $img->getClientOriginalName();
         //$img->store('public/imagenes');
         //$url = Storage::url($ruta);

         // crear un nuevo usuario en la base de datos
        //  $usuario = new colaborador();
        //  $usuario->nombres = $nombres;
        //  $usuario->apellidos = $apellidos;
        //  $usuario->correo = $correo;
        //  $usuario->dui = $dui;
        //  $usuario->clave = $clave;
        //  $usuario->telefono = $telefono;
        //  $usuario->correo = $correo;
        //  $usuario->agencia_id = $agencia_id;
        //  $usuario->departamento_id = $departamento_id;
        //  $usuario->cargo_id = $cargo_id;
        //  $usuario->habilitado = 'S';
         //$usuario->foto = $nombreImg;
        //  $usuario->intentos = 5;
        //  $usuario->created_at = now();
         // guardar el usuario en la base de datos
         //$usuario->save();

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
        $token = JWTAuth::fromUser($user);

         // devolver una respuesta JSON con el nuevo user
         return response()->json([
             'user' => $user,
             'token' => $token,
             'success' => true
         ], 201);
    }

    public function singIn(AuthRequest $request) {
        $credentials = $request->only('dui','password');

        try {
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'error' => 'Credenciales invalidas'
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Token no creado'
            ], 500);
        }
        return response()->json([compact('token')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $colab = User::find($request->id);
        return response()->json([
            'dataDB' => $colab,
            'success' => true
        ]);
    }

    public function buscar(Request $request)
    {
        $colab = DB::table('users')
                ->select('users.password AS clave', 'users.intentos AS intentos', 'users.id AS id')
                ->where('users.dui', $request->dui)
                ->get();
        return response()->json([
            'dataDB' => $colab,
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $colab)
    {
        $colaborador = User::findOrFail($colab->id)->update([
            'habilitado' => 'N'
        ]);
        return response()->json([
            'dataDB' => $colaborador,
            'success' => true
        ]);
    }

    public function desbloquear(Request $colab)
    {
        $colaborador = User::findOrFail($colab->id)->update([
            'intentos' => 5
        ]);
        return response()->json([
            'dataDB' => $colaborador,
            'success' => true
        ]);
    }

    public function editarIntentos(Request $request)
    {
        // return $request->dui;
        // die;

        // $colaborador = colaborador::findOrFail($request->dui)->update([
        //     'intentos' => 0
        // ]);
        // return response()->json([
        //     'dataDB' => $colaborador,
        //     'success' => true
        // ]);

        $colab = DB::table('users')
                ->where('users.dui', $request->dui)
                ->update(['intentos' => 0]);

        return response()->json([
            'dataDB' => $colab,
            'success' => true
        ]);
    }
    public function editarIntentosEquivocados(Request $request)
    {
        // return $request->dui;
        // die;

        // $user = User::findOrFail($request->dui)->decrement('intentos',1);
        
        // return response()->json([
        //     'dataDB' => $user,
        //     'success' => true
        // ]);

        $colab = DB::table('users')
                ->where('users.dui', $request->dui)
                ->decrement('intentos',1);
                //->update(['intentos' => 0]);

        return response()->json([
            'dataDB' => $colab,
            'success' => true
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $registro = User::findOrFail($id);
        $registro->foto = $request->foto;
        $registro->dui = $request->dui;
        $registro->nombres = $request->nombres;
        $registro->apellidos = $request->apellidos;
        $registro->agencia_id = $request->agencia;
        $registro->departamento_id = $request->departamento;
        $registro->cargo_id = $request->cargo;
        $registro->telefono = $request->telefono;
        $registro->correo = $request->correo;
        $registro->save();
        return response()->json([
            'dataDB' => $registro,
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
