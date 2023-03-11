<?php

namespace App\Http\Controllers;

use App\Models\colaborador;
use App\Models\detalleDepartamentoCargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class colaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $colaborador = DB::table('colaboradors')
                ->select('agencias.nombre AS agencia', 'agencias.id AS agencia_id', 'departamentos.nombre AS departamento', 'departamentos.id AS departamento_id', 'cargos.nombre as cargo', 'cargos.id AS cargo_id', 'colaboradors.nombres AS nombre', 'colaboradors.apellidos AS apellido', 'colaboradors.telefono AS telefono', 'colaboradors.correo AS email', 'colaboradors.dui AS dui')
                ->join('agencias', 'colaboradors.agencia_id', '=', 'agencias.id')
                ->join('departamentos', 'colaboradors.departamento_id', '=', 'departamentos.id')
                ->join('cargos', 'colaboradors.cargo_id', '=', 'cargos.id')
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
         $nombres = $request->input('nombres');
         $apellidos = $request->input('apellidos');
         $correo = $request->input('correo');
         $dui = $request->input('dui');
         $clave = $request->input('clave');
         $telefono = $request->input('telefono');
         $correo = $request->input('correo');
         $agencia_id = $request->input('agencia');
         $departamento_id = $request->input('departamento');
         $cargo_id = $request->input('cargo');
         $foto = $request->input('foto');

         // crear un nuevo usuario en la base de datos
         $usuario = new colaborador();
         $usuario->nombres = $nombres;
         $usuario->apellidos = $apellidos;
         $usuario->correo = $correo;
         $usuario->dui = $dui;
         $usuario->clave = $clave;
         $usuario->telefono = $telefono;
         $usuario->correo = $correo;
         $usuario->agencia_id = $agencia_id;
         $usuario->departamento_id = $departamento_id;
         $usuario->cargo_id = $cargo_id;
         $usuario->habilitado = 'S';
         $usuario->foto = $foto;
         $usuario->intentos = 5;
         $usuario->created_at = now();

         // guardar el usuario en la base de datos
         $usuario->save();

         // devolver una respuesta JSON con el nuevo usuario
         return response()->json([
             'usuario' => $usuario
         ]);
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
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
