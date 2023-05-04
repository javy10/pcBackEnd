<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallePermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $permisos = DB::table('detalle_permisos')
            ->join('permisos', 'detalle_permisos.permiso_id', '=', 'permisos.id')
            ->join('documentos', 'permisos.documento_id','=','documentos.id')
            ->select('permisos.documento_id', 'permisos.tipoPermiso_id', 'detalle_permisos.departamento_id', 'detalle_permisos.colaborador_id', 'detalle_permisos.created_at')
            ->get();

        return response()->json([
            'dataDB' => $permisos,
            'success' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
        $permisos = DB::table('detalle_permisos')
            ->join('permisos', 'detalle_permisos.permiso_id', '=', 'permisos.id')
            ->leftJoin('departamentos', 'detalle_permisos.departamento_id','=','departamentos.id')
            ->leftJoin('users', 'detalle_permisos.colaborador_id','=','users.id')
            ->select('permisos.documento_id', 'permisos.tipoPermiso_id', 'permisos.id AS permiso_id', 'detalle_permisos.departamento_id', 'departamentos.nombre', 'detalle_permisos.colaborador_id', 'users.nombres', 'users.apellidos', 'detalle_permisos.created_at', 'detalle_permisos.id')
            ->where('permisos.documento_id', '=', $request->id)
            ->get();

        return response()->json([
            'dataDB' => $permisos,
            'success' => true
        ]);
        
    }

    public function detalleID(Request $request)
    {
        //
        $permisos = DB::table('detalle_permisos')
            ->join('permisos', 'detalle_permisos.permiso_id', '=', 'permisos.id')
            ->leftJoin('departamentos', 'detalle_permisos.departamento_id','=','departamentos.id')
            ->leftJoin('users', 'detalle_permisos.colaborador_id','=','users.id')
            ->select('permisos.documento_id', 'permisos.tipoPermiso_id', 'permisos.id AS permiso_id', 'detalle_permisos.departamento_id', 'departamentos.nombre', 'detalle_permisos.colaborador_id', 'users.nombres', 'users.apellidos', 'detalle_permisos.created_at', 'detalle_permisos.id')
            ->where('Detalle_permisos.id', '=', $request->id)
            ->get();

        return response()->json([
            'dataDB' => $permisos,
            'success' => true
        ]);
        
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
