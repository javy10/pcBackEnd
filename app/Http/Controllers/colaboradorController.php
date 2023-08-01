<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Models\cargo;
use App\Models\ConfigDepartamentocargo;
use App\Models\DetallePermisoMenu;
use App\Models\PermisoMenu;
use App\Models\User as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Password;

class colaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $colaborador = DB::table('users')
        //         ->select('agencias.nombre AS agencia', 'agencias.id AS agencia_id', 'departamentos.nombre AS departamento', 'departamentos.id AS departamento_id', 'cargos.nombre as cargo', 'cargos.id AS cargo_id', 'users.nombres AS nombres', 'users.apellidos AS apellidos', 'users.telefono AS telefono', 'users.email AS correo', 'users.dui AS dui', 'users.id AS id', 'users.foto AS foto', 'users.intentos AS intentos', 'logs_entrada_salidas.fechaSalida')
        //         ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
        //         ->join('departamentos', 'users.departamento_id', '=', 'departamentos.id')
        //         ->join('cargos', 'users.cargo_id', '=', 'cargos.id')
        //         ->leftJoin('logs_entrada_salidas', 'logs_entrada_salidas.colaborador_id', '=', 'users.id')
        //         ->where('users.habilitado', 'S')
        //         ->get();

         $colaborador = DB::table('users')
                ->select('agencias.nombre AS agencia', 'agencias.id AS agencia_id', 'departamentos.nombre AS departamento', 'departamentos.id AS departamento_id', 'cargos.nombre as cargo', 'cargos.id AS cargo_id', 'users.nombres AS nombres', 'users.apellidos AS apellidos', 'users.telefono AS telefono', 'users.email AS correo', 'users.dui AS dui', 'users.id AS id', 'users.foto AS foto', 'users.intentos AS intentos', 'logs_entrada_salidas.fechaSalida')
                ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
                ->join('config_departamentocargos', 'config_departamentocargos.colaborador_id', '=', 'users.id')
                ->join('departamentos', 'config_departamentocargos.departamento_id', '=', 'departamentos.id')
                ->join('cargos', 'config_departamentocargos.cargo_id', '=', 'cargos.id')
                ->leftJoin('logs_entrada_salidas', 'logs_entrada_salidas.colaborador_id', '=', 'users.id')
                ->where('users.habilitado', 'S')
                ->get();

        return response()->json([
            'dataDB' => $colaborador,
            'success' => true
        ]);
    }

    public function filtroUsuarios(Request $request){

        // $colaborador = DB::table('users')
        //             ->select('agencias.nombre AS agencia', 'agencias.id AS agencia_id', 'departamentos.nombre AS departamento', 'departamentos.id AS departamento_id', 'cargos.nombre as cargo', 'cargos.id AS cargo_id', 'users.nombres AS nombres', 'users.apellidos AS apellidos', 'users.id AS id', 'logs_entrada_salidas.fechaSalida')
        //             ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
        //             ->join('departamentos', 'users.departamento_id', '=', 'departamentos.id')
        //             ->join('cargos', 'users.cargo_id', '=', 'cargos.id')
        //             ->leftJoin('logs_entrada_salidas', 'logs_entrada_salidas.colaborador_id', '=', 'users.id')
        //             ->where('users.habilitado', 'S')
        //             ->where('users.nombres', 'LIKE', '%'.$request->nombre.'%')
        //             ->orwhere('users.apellidos', 'LIKE', '%'.$request->nombre.'%')
        //             ->get();

        $colaborador = DB::table('users')
            ->select('agencias.nombre AS agencia', 'agencias.id AS agencia_id', 'departamentos.nombre AS departamento', 'departamentos.id AS departamento_id', 'cargos.nombre as cargo', 'cargos.id AS cargo_id', 'users.nombres AS nombres', 'users.apellidos AS apellidos', 'users.id AS id', 'logs_entrada_salidas.fechaSalida')
            ->join('config_departamentocargos', 'config_departamentocargos.colaborador_id', '=', 'users.id')
            ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
            ->join('departamentos', 'config_departamentocargos.departamento_id', '=', 'departamentos.id')
            ->join('cargos', 'config_departamentocargos.cargo_id', '=', 'cargos.id')
            ->leftJoin('logs_entrada_salidas', 'logs_entrada_salidas.colaborador_id', '=', 'users.id')
            ->where('users.habilitado', 'S')
            ->where(function ($query) use ($request) {
                $query->where('users.nombres', 'LIKE', '%'.$request->nombre.'%')
                      ->orWhere('users.apellidos', 'LIKE', '%'.$request->nombre.'%');
            })
            ->get();


        return response()->json([
            'dataDB' => $colaborador,
            'success' => true
        ]);
    }

    public function Deshabilitados()
    {
         $colaborador = DB::table('users')
                ->select('agencias.nombre AS agencia', 'agencias.id AS agencia_id', 'departamentos.nombre AS departamento', 'departamentos.id AS departamento_id', 'cargos.nombre as cargo', 'cargos.id AS cargo_id', 'users.nombres AS nombres', 'users.apellidos AS apellidos', 'users.telefono AS telefono', 'users.email AS correo', 'users.dui AS dui', 'users.id AS id', 'users.foto AS foto', 'users.intentos AS intentos')
                ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
                ->join('departamentos', 'users.departamento_id', '=', 'departamentos.id')
                ->join('cargos', 'users.cargo_id', '=', 'cargos.id')
                ->where('users.habilitado', 'N')
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

        // return $request->cargo_id;
        // die;
        
        // $config = new ConfigDepartamentocargo();
        // $config->departamento_id = $request->departamento_id;
        // $config->cargo_id = $request->cargo_id;
        // $config->colaborador_id = $request->colaborador_id;
        // $config->habilitado = 'S';
        // $config->save();

        // return response()->json([
        //     'success' => true
        // ], 201);

        // //return $request;
        $file = $request->file('foto');
        if($file != null || $file != '') 
        {
            $fileName = $file->getClientOriginalName();
            $filePath = public_path($fileName);
            $path = $file->storeAs('public/imagenes', $fileName);

            $user = new User();
            $user->nombres = $request->nombres;
            $user->apellidos = $request->apellidos;
            $user->email = $request->correo;
            $user->password = Hash::make($request->password);
            $user->agencia_id = $request->agencia_id;
            $user->dui = $request->dui;
            $user->telefono = $request->telefono == '' ? null : $request->telefono;
            $user->intentos = $request->intentos;
            $user->habilitado = $request->habilitado;
            $user->foto = $fileName;
            $user->save();
            $token = JWTAuth::fromUser($user);

            $cargos = json_decode($request->cargo_id);
            foreach ($cargos as $item) {

                $departamentoId = cargo::where('id', $item)->pluck('departamento_id')->first();
                $config = new ConfigDepartamentocargo();
                $config->colaborador_id = $user->id;
                $config->departamento_id = $departamentoId;
                $config->cargo_id = $item;
                $config->habilitado = 'S';
                $config->save();
                if($request->menu_id) {
                    $permisoMenu = new PermisoMenu();
                    $permisoMenu->tipoPermisoMenu_id = $request->tipoPermisoMenu_id;
                    $permisoMenu->habilitado = 'S';
                    $permisoMenu->save();

                    $myArray = json_decode($request->menu_id);
                    foreach ($myArray as $itemMenu) {
                        $detallePermisoMenu = new DetallePermisoMenu();
                        $detallePermisoMenu->permisoMenu_id = $permisoMenu->id;
                        $detallePermisoMenu->menu_id = $itemMenu;
                        $detallePermisoMenu->departamento_id = $departamentoId;
                        $detallePermisoMenu->cargo_id = $item;
                        $detallePermisoMenu->colaborador_id = $user->id;
                        $detallePermisoMenu->habilitado = 'S';
                        $detallePermisoMenu->save();
                    }    
                }
            }
            return response()->json([
                'success' => true
            ], 201);

        } else {
            $user = new User();
            $user->nombres = $request->nombres;
            $user->apellidos = $request->apellidos;
            $user->email = $request->correo;
            $user->password = Hash::make($request->password);
            $user->agencia_id = $request->agencia_id;
            $user->dui = $request->dui;
            $user->telefono = $request->telefono == '' ? null : $request->telefono;
            $user->intentos = $request->intentos;
            $user->habilitado = $request->habilitado;
            $user->save();
            $token = JWTAuth::fromUser($user);

            $cargos = json_decode($request->cargo_id);
            foreach ($cargos as $item) {
                $departamentoId = cargo::where('id', $item)->pluck('departamento_id')->first();
                $config = new ConfigDepartamentocargo();
                $config->colaborador_id = $user->id;
                $config->departamento_id = $departamentoId;
                $config->cargo_id = $item;
                $config->habilitado = 'S';
                $config->save();
                if($request->menu_id) {
                    $permisoMenu = new PermisoMenu();
                    $permisoMenu->tipoPermisoMenu_id = $request->tipoPermisoMenu_id;
                    $permisoMenu->habilitado = 'S';
                    $permisoMenu->save();
                    $myArray = json_decode($request->menu_id);
                    foreach ($myArray as $itemMenu) {
                        $detallePermisoMenu = new DetallePermisoMenu();
                        $detallePermisoMenu->permisoMenu_id = $permisoMenu->id;
                        $detallePermisoMenu->menu_id = $itemMenu;
                        $detallePermisoMenu->departamento_id = $departamentoId;
                        $detallePermisoMenu->cargo_id = $item;
                        $detallePermisoMenu->colaborador_id = $user->id;
                        $detallePermisoMenu->habilitado = 'S';
                        $detallePermisoMenu->save();
                    }    
                }
            }
            return response()->json([
                'success' => true
            ], 201);
        }
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

        // $user = User::select('nombres', 'apellidos', 'dui', 'telefono', 'email', 'foto', 'agencias.nombre as Agencia', 'agencias.id as agencia_id', 'departamentos.nombre as Departamento', 'departamentos.id as departamento_id', 'cargos.nombre as Cargo', 'cargos.id as cargo_id')
        //             ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
        //             ->join('departamentos', 'users.departamento_id', '=', 'departamentos.id')
        //             ->join('cargos', 'users.cargo_id', '=', 'cargos.id')
        //             ->where('users.id', '=', $request->id)
        //             ->get();
        // return response()->json([
        //     'dataDB' => $user,
        //     'success' => true
        // ]);
    }

    public function obtenerColaboradorID(Request $request)
    {
        // $colab = User::find($request->id);
        // return response()->json([
        //     'dataDB' => $colab,
        //     'success' => true
        // ]);

        // $user = User::select('nombres', 'apellidos', 'dui', 'telefono', 'email', 'foto', 'agencias.nombre as Agencia', 'agencias.codAgencia', 'agencias.id as agencia_id', 'departamentos.nombre as Departamento', 'departamentos.id as departamento_id', 'cargos.nombre as Cargo', 'cargos.id as cargo_id')
        //             ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
        //             ->join('departamentos', 'users.departamento_id', '=', 'departamentos.id')
        //             ->join('cargos', 'users.cargo_id', '=', 'cargos.id')
        //             ->where('users.id', '=', $request->id)
        //             ->get();

        $user = User::select('nombres', 'apellidos', 'dui', 'telefono', 'email', 'foto', 'agencias.nombre as Agencia', 'agencias.codAgencia', 'agencias.id as agencia_id', 'departamentos.nombre as Departamento', 'departamentos.id as departamento_id', 'cargos.nombre as Cargo', 'cargos.id as cargo_id')
                    ->join('config_departamentocargos', 'config_departamentocargos.colaborador_id', '=', 'users.id')
                    ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
                    ->join('departamentos', 'config_departamentocargos.departamento_id', '=', 'departamentos.id')
                    ->join('cargos', 'config_departamentocargos.cargo_id', '=', 'cargos.id')
                    ->where('users.id', '=', $request->id)
                    ->get();

        return response()->json([
            'dataDB' => $user,
            'success' => true
        ]);
    }

    public function obtenerPorIDColaborador(Request $request)
    {

        $user = User::select('users.nombres', 'users.apellidos', 'users.dui', 'users.telefono', 'users.email', 'users.foto', 'agencias.nombre as Agencia', 'agencias.codAgencia', 'agencias.id as agencia_id', 'departamentos.nombre as Departamento', 'departamentos.id as departamento_id', 'cargos.nombre as Cargo', 'cargos.id as cargo_id')
        ->join('config_departamentocargos', 'config_departamentocargos.colaborador_id', '=', 'users.id')
        ->join('agencias', 'users.agencia_id', '=', 'agencias.id')
        ->join('departamentos', 'config_departamentocargos.departamento_id', '=', 'departamentos.id')
        ->join('cargos', 'config_departamentocargos.cargo_id', '=', 'cargos.id')
        ->where('users.id', '=', $request->id)
        ->get();

        return response()->json([
            'dataDB' => $user,
            'success' => true
        ]);
    }

    public function buscarPorClave(Request $request)
    {

        // Obtener el usuario por correo electrónico
        $user = User::where('id', $request->colaborador_id)->first();

        // Verificar si la contraseña ingresada coincide con el hash almacenado en la base de datos
        if ($user && Hash::check($request->clave, $user->password)) {
            return response()->json([
                'dataDB' => $user,
                'success' => true
            ]);
        } else {
            return response()->json([
                'dataDB' => $user,
                'success' => false
            ]);
        }
    }

    public function buscar(Request $request)
    {
        $colab = DB::table('users')
                ->select('users.password AS clave', 'users.intentos AS intentos', 'users.id AS id')
                ->where('users.dui', $request->dui)
                ->where('users.habilitado', '=', 'S')
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
            // 'dataDB' => $colaborador,
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

    public function reestablecerIntentos(Request $request)
    {
        // return $request->dui;
        // die;
       
        $colab = DB::table('users')
                ->where('users.dui', $request->dui)
                ->update(['intentos' => 5]);

        return response()->json([
            'dataDB' => $colab,
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
        
        // return $request;
        // die;

        $colaborador = User::findOrFail($request->colaborador_id)->update(['password' => Hash::make($request->clave)]);
        return response()->json([
            'dataDB' => $colaborador,
            'success' => true
        ]);
    }

    public function obtenerUsersPorEmail(Request $request)
    {
        $resultado = DB::table('users')
                        ->select('id', DB::raw('COUNT(*) as total_usuarios'))
                        ->where('email', '=', $request->email)
                        ->get();

        return response()->json([
            'dataDB' => $resultado,
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
        // return $request->id;
        // die;


        $file = $request->file('foto');
        if($file != null || $file != '') 
        {
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
                'telefono' => $request->telefono,
                'email' => $request->correo,
            ]);

            //  PARA ACTUALIZAR LOS DATOS DEL MENU EN LA TABLA DE DETALLE PERMISO MENU
            // Paso 1: Obtener los nuevos usuarios_id
            $nuevosPermisosMenuId = $request->input('menu_id');
            $cadenas = $nuevosPermisosMenuId;
            $arrayMenu = explode(',', $cadenas);
            $arrayMenu = array_map(function($value) {
                return intval(trim($value, "[]"));
            }, $arrayMenu);

            // return $arrayMenu;
            // die;

            // Paso 2: Recuperar los registros existentes
            $registrosExistentePermisoMenu = DetallePermisoMenu::where('colaborador_id', $request->id)->get();
            // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
            $cargoIdExistente = $registrosExistentePermisoMenu->pluck('menu_id')->toArray();
            $cargosIdEliminar = array_diff($cargoIdExistente, $arrayMenu);
            $cargosIdAgregar = array_diff($arrayMenu, $cargoIdExistente);

            // return $cargosIdAgregar;
            // die;

            if(!empty($cargosIdEliminar)){
                //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
                DetallePermisoMenu::where('colaborador_id', $request->id)
                ->whereIn('menu_id', $cargosIdEliminar)
                ->delete();
                //->update(['habilitado' => 'N']);
            }
            // Paso 1: Obtener los nuevos usuarios_id
            $nuevosPermisosUserId = $request->input('cargo_id');
            $cadenas = $nuevosPermisosUserId;
            $array = explode(',', $cadenas);
            $array = array_map(function($value) {
                return intval(trim($value, "[]"));
            }, $array);
            // Paso 2: Recuperar los registros existentes
            $registrosExistente = ConfigDepartamentocargo::where('colaborador_id', $request->id)->get();
            // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
            $colaboradoresIdExistente = $registrosExistente->pluck('cargo_id')->toArray();
            $colaboradoresIdEliminar = array_diff($colaboradoresIdExistente, $array);
            $colaboraoresIdAgregar = array_diff($array, $colaboradoresIdExistente);
            //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
            // ConfigDepartamentocargo::where('colaborador_id', $request->id)
            // ->whereIn('cargo_id', $colaboradoresIdEliminar)
            // ->delete();
            if(!empty($colaboradoresIdEliminar)){
                ConfigDepartamentocargo::where('colaborador_id', $request->id)
                ->whereIn('cargo_id', $colaboradoresIdEliminar)
                ->delete();
                //->update(['habilitado' => 'N']);
            }
            // return $registrosExistente;
            // die;
            if($colaboraoresIdAgregar) {
                // Paso 5: Agregar los nuevos registros para los usuarios_id que no están en los registros existentes
                foreach ($colaboraoresIdAgregar as $item) {
                    $departamentoId = cargo::where('id', $item)->pluck('departamento_id')->first();
                    $config = new ConfigDepartamentocargo();
                    $config->colaborador_id = $user->id;
                    $config->departamento_id = $departamentoId;
                    $config->cargo_id = $item;
                    $config->habilitado = 'S';
                    $config->save();

                    $permisoMenu = new PermisoMenu();
                    $permisoMenu->tipoPermisoMenu_id = $request->tipoPermisoMenu_id;
                    $permisoMenu->habilitado = 'S';
                    $permisoMenu->save();

                    if(!empty(array_diff($cargosIdAgregar, [0]))){
                        foreach ($cargosIdAgregar as $itemMenu) {
                            $detallePermisoMenu = new DetallePermisoMenu();
                            $detallePermisoMenu->permisoMenu_id = $permisoMenu->id;
                            $detallePermisoMenu->menu_id = $itemMenu;
                            $detallePermisoMenu->departamento_id = $departamentoId;
                            $detallePermisoMenu->cargo_id = $item;
                            $detallePermisoMenu->colaborador_id = $user->id;
                            $detallePermisoMenu->habilitado = 'S';
                            $detallePermisoMenu->save();
                        }  
                    }
                }
                return response()->json([
                    // 'dataDB' => $user,
                    'success' => true
                ]);
            }
             else {
                foreach ($colaboradoresIdExistente as $item) {
                    // return $cargosIdAgregar;
                    // die;
                    if(!empty(array_diff($cargosIdAgregar, [0]))){
                        $departamentoId = cargo::where('id', $item)->pluck('departamento_id')->first();
                        $permisoMenu = new PermisoMenu();
                        $permisoMenu->tipoPermisoMenu_id = $request->tipoPermisoMenu_id;
                        $permisoMenu->habilitado = 'S';
                        $permisoMenu->save();
                        //$myArray = json_decode($request->menu_id);
                        foreach ($cargosIdAgregar as $itemMenu) {
                            $detallePermisoMenu = new DetallePermisoMenu();
                            $detallePermisoMenu->permisoMenu_id = $permisoMenu->id;
                            $detallePermisoMenu->menu_id = $itemMenu;
                            $detallePermisoMenu->departamento_id = $departamentoId;
                            $detallePermisoMenu->cargo_id = $item;
                            $detallePermisoMenu->colaborador_id = $user->id;
                            $detallePermisoMenu->habilitado = 'S';
                            $detallePermisoMenu->save();
                        }  
                    }
                }
                return response()->json([
                    // 'dataDB' => $user,
                    'success' => true
                ]);
            }
        } else {
            $user = User::find($request->id);
            $user->update([
                'dui' => $request->dui,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'agencia_id' => $request->agencia_id,
                'telefono' => $request->telefono,
                'email' => $request->correo,
            ]);

            //  PARA ACTUALIZAR LOS DATOS DEL MENU EN LA TABLA DE DETALLE PERMISO MENU
            // Paso 1: Obtener los nuevos usuarios_id
            $nuevosPermisosMenuId = $request->input('menu_id');
            $cadenas = $nuevosPermisosMenuId;
            $arrayMenu = explode(',', $cadenas);
            $arrayMenu = array_map(function($value) {
                return intval(trim($value, "[]"));
            }, $arrayMenu);

            // return $arrayMenu;
            // die;

            // Paso 2: Recuperar los registros existentes
            $registrosExistentePermisoMenu = DetallePermisoMenu::where('colaborador_id', $request->id)->get();
            // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
            $cargoIdExistente = $registrosExistentePermisoMenu->pluck('menu_id')->toArray();
            $cargosIdEliminar = array_diff($cargoIdExistente, $arrayMenu);
            $cargosIdAgregar = array_diff($arrayMenu, $cargoIdExistente);

            // return $cargosIdAgregar;
            // die;

            if(!empty($cargosIdEliminar)){
                //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
                DetallePermisoMenu::where('colaborador_id', $request->id)
                ->whereIn('menu_id', $cargosIdEliminar)
                ->delete();
                //->update(['habilitado' => 'N']);
            }
            // Paso 1: Obtener los nuevos usuarios_id
            $nuevosPermisosUserId = $request->input('cargo_id');
            $cadenas = $nuevosPermisosUserId;
            $array = explode(',', $cadenas);
            $array = array_map(function($value) {
                return intval(trim($value, "[]"));
            }, $array);
            // Paso 2: Recuperar los registros existentes
            $registrosExistente = ConfigDepartamentocargo::where('colaborador_id', $request->id)->get();
            // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
            $colaboradoresIdExistente = $registrosExistente->pluck('cargo_id')->toArray();
            $colaboradoresIdEliminar = array_diff($colaboradoresIdExistente, $array);
            $colaboraoresIdAgregar = array_diff($array, $colaboradoresIdExistente);
            //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
            // ConfigDepartamentocargo::where('colaborador_id', $request->id)
            // ->whereIn('cargo_id', $colaboradoresIdEliminar)
            // ->delete();
            if(!empty($colaboradoresIdEliminar)){
                ConfigDepartamentocargo::where('colaborador_id', $request->id)
                ->whereIn('cargo_id', $colaboradoresIdEliminar)
                ->delete();
                //->update(['habilitado' => 'N']);
            }
            // return $registrosExistente;
            // die;

            if($colaboraoresIdAgregar) {
                // Paso 5: Agregar los nuevos registros para los usuarios_id que no están en los registros existentes
                foreach ($colaboraoresIdAgregar as $item) {
    
                    $departamentoId = cargo::where('id', $item)->pluck('departamento_id')->first();
                    $config = new ConfigDepartamentocargo();
                    $config->colaborador_id = $user->id;
                    $config->departamento_id = $departamentoId;
                    $config->cargo_id = $item;
                    $config->habilitado = 'S';
                    $config->save();

                    $permisoMenu = new PermisoMenu();
                    $permisoMenu->tipoPermisoMenu_id = $request->tipoPermisoMenu_id;
                    $permisoMenu->habilitado = 'S';
                    $permisoMenu->save();
        
                    if(!empty(array_diff($cargosIdAgregar, [0]))){
                        foreach ($cargosIdAgregar as $itemMenu) {
                            $detallePermisoMenu = new DetallePermisoMenu();
                            $detallePermisoMenu->permisoMenu_id = $permisoMenu->id;
                            $detallePermisoMenu->menu_id = $itemMenu;
                            $detallePermisoMenu->departamento_id = $departamentoId;
                            $detallePermisoMenu->cargo_id = $item;
                            $detallePermisoMenu->colaborador_id = $user->id;
                            $detallePermisoMenu->habilitado = 'S';
                            $detallePermisoMenu->save();
                        }  
                    }
                }

                return response()->json([
                    // 'dataDB' => $user,
                    'success' => true
                ]);

            }
             else {

                foreach ($colaboradoresIdExistente as $item) {

                    // return $cargosIdAgregar;
                    // die;

                    if(!empty(array_diff($cargosIdAgregar, [0]))){
                        $departamentoId = cargo::where('id', $item)->pluck('departamento_id')->first();
    
                        $permisoMenu = new PermisoMenu();
                        $permisoMenu->tipoPermisoMenu_id = $request->tipoPermisoMenu_id;
                        $permisoMenu->habilitado = 'S';
                        $permisoMenu->save();
            
                        //$myArray = json_decode($request->menu_id);
            
                        foreach ($cargosIdAgregar as $itemMenu) {
                            $detallePermisoMenu = new DetallePermisoMenu();
                            $detallePermisoMenu->permisoMenu_id = $permisoMenu->id;
                            $detallePermisoMenu->menu_id = $itemMenu;
                            $detallePermisoMenu->departamento_id = $departamentoId;
                            $detallePermisoMenu->cargo_id = $item;
                            $detallePermisoMenu->colaborador_id = $user->id;
                            $detallePermisoMenu->habilitado = 'S';
                            $detallePermisoMenu->save();
                        }  
                    }
                }
                return response()->json([
                    // 'dataDB' => $user,
                    'success' => true
                ]);
            }


        }

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


    public function recover(Request $request)
    {

        //return $request->email;
        
        //$request->validate(['correo' => 'required|email']);

        $response = Password::sendResetLink(['email' => $request->input('email')]);

        // return $response;
        // die;

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Correo electrónico de recuperación enviado',
                'success' => true
            ],
            200);
        } else {
            return response()->json(['error' => 'No se pudo enviar el correo electrónico de recuperación'], 400);
        }
    }





}
