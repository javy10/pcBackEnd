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
use Illuminate\Support\Facades\File;

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

        // echo $request->foto;
        // echo gettype($request->foto);


        $file = $request->file('foto');
        $fileName = $file->getClientOriginalName();
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
             'user' => $user,
             'token' => $token,
             'success' => true
         ], 201);
    }

    public function obtenerFoto(Request $request)
    {
        
        $file = public_path('storage\\imagenes\\'.$request->nombre);
        if (!File::exists($file)) {
            return 'No encontrado';
        } else {
            $type = File::mimeType($file);
            $headers = array('Content-Type', $type);
            return response()->file($file, $headers);
        }
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

    public function editPassword(Request $request)
    {
        $colaborador = User::findOrFail($request->id)
                    ->update(['password' => Hash::make($request->clave)]);
        return response()->json([
            'dataDB' => $colaborador,
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
    public function update(Request $request)
    {

        //return $request;
        $file = $request->file('foto');
        $fileName = $file->getClientOriginalName();
        $filePath = public_path($fileName);
        $path = $file->storeAs('public/imagenes', $fileName);

        $user = User::find($request->id);
        $user->update([
            'foto' => $fileName,
            'dui' => $request->dui,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'agencia_id' => $request->agencia_id,
            'departamento_id' => $request->departamento_id,
            'cargo_id' => $request->cargo_id,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
        ]);
        return response()->json([
            'dataDB' => $user,
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
