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
                ->select('agencias.nombre AS agencia', 'agencias.id AS agencia_id', 'departamentos.nombre AS departamento', 'departamentos.id AS departamento_id', 'cargos.nombre as cargo', 'cargos.id AS cargo_id', 'colaboradors.nombres AS nombres', 'colaboradors.apellidos AS apellidos', 'colaboradors.telefono AS telefono', 'colaboradors.correo AS correo', 'colaboradors.dui AS dui', 'colaboradors.id AS id')
                ->join('agencias', 'colaboradors.agencia_id', '=', 'agencias.id')
                ->join('departamentos', 'colaboradors.departamento_id', '=', 'departamentos.id')
                ->join('cargos', 'colaboradors.cargo_id', '=', 'cargos.id')
                ->where('colaboradors.habilitado', 'S')
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
    public function show(Request $request)
    {
        $colab = colaborador::find($request->id);
        return $colab;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $colab)
    {
        $colaborador = colaborador::findOrFail($colab->id)->update([
            'habilitado' => 'N'
        ]);
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
    public function update(Request $request, $id)
    {
        $registro = colaborador::findOrFail($id);
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
