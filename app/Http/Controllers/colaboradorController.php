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
                 ->join('agencias', 'colaboradors.agencia_id', '=', 'agencias.id')
                 ->join('detalle_departamento_cargos', 'colaboradors.detalle_departamento_cargo_id', '=','detalle_departamento_cargos.id')
                 ->join('departamentos', 'detalle_departamento_cargos.departamento_id', '=', 'departamentos.id')
                 ->join('cargos', 'detalle_departamento_cargos.cargo_id', '=', 'cargos.id')
                 ->select('agencias.nombre AS agencia', 'departamentos.nombre AS departamento', 'cargos.nombre as cargo', 'colaboradors.nombres AS nombre', 'colaboradors.apellidos AS apellido')
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
         // obtener los datos del usuario de la solicitud POST
         $nombres = $request->input('nombres');
         $correo = $request->input('correo');
         $dui = $request->input('dui');
         $clave = $request->input('clave');
         $telefono = $request->input('telefono');
         $correo = $request->input('correo');
         $agencia_id = $request->input('agencia_id');
         $departamento_id = $request->input('departamento');
         $cargo_id = $request->input('cargo');

        //insertando en la primera tabal
        $detalle = new detalleDepartamentoCargo();
        $detalle->departamento_id = $departamento_id;
        $detalle->cargo_id = $cargo_id;
        $detalle->habilitado = 'S';
        $detalle->created_at = now();
        $detalle->save();

        //obtenemos el id del detalle insertado
        // $detalle_id = $detalle->id;

        //  // crear un nuevo usuario en la base de datos
        //  $usuario = new colaborador();
        //  $usuario->nombres = $nombres;
        //  $usuario->correo = $correo;
        //  $usuario->dui = $dui;
        //  $usuario->clave = $clave;
        //  $usuario->telefono = $telefono;
        //  $usuario->correo = $correo;
        //  $usuario->agencia_id = $agencia_id;
        //  $usuario->detalle_departamento_cargo_id = $detalle_id;
        //  $usuario->habilitado = 'S';
        //  $usuario->created_at = now();

        //  // guardar el usuario en la base de datos
        //  $usuario->save();

        //  // devolver una respuesta JSON con el nuevo usuario
        //  return response()->json([
        //      'usuario' => $usuario
        //  ]);
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
