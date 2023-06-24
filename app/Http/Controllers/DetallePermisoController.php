<?php

namespace App\Http\Controllers;

use App\Models\DetallePermiso;
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
            ->join('documentos', 'detalle_permisos.documento_id','=','documentos.id')
            ->select('detalle_permisos.documento_id', 'permisos.tipoPermiso_id', 'detalle_permisos.departamento_id', 'detalle_permisos.colaborador_id', 'detalle_permisos.created_at')
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
        $colaborador_permisos = DB::table('detalle_permisos')
                    ->select('colaborador_id')
                    ->where('documento_id', '=', $request->id)
                    ->get();
        return response()->json([
            'dataDB' => $colaborador_permisos,
            'success' => true
        ]);

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
            ->select('detalle_permisos.documento_id', 'permisos.tipoPermiso_id', 'permisos.id AS permiso_id', 'detalle_permisos.departamento_id', 'departamentos.nombre', 'detalle_permisos.colaborador_id', 'users.nombres', 'users.apellidos', 'detalle_permisos.created_at', 'detalle_permisos.id')
            ->where('detalle_permisos.documento_id', '=', $request->id)
            
            ->get();

        return response()->json([
            'dataDB' => $permisos,
            'success' => true
        ]);
        
    }

    public function obtenerDetallePermiso()
    {
        //
        $detalle = DB::table('detalle_permisos')
            ->join('permisos', 'detalle_permisos.permiso_id', '=', 'permisos.id')
            ->leftJoin('departamentos', 'detalle_permisos.departamento_id','=','departamentos.id')
            ->leftJoin('users', 'detalle_permisos.colaborador_id','=','users.id')
            ->join('documentos', 'detalle_permisos.documento_id', '=', 'documentos.id')
            ->select('detalle_permisos.documento_id', 'documentos.titulo', 'permisos.tipoPermiso_id', 'permisos.id AS permiso_id', 'detalle_permisos.departamento_id', 'departamentos.nombre', 'detalle_permisos.colaborador_id', 'users.nombres', 'users.apellidos', 'detalle_permisos.created_at', 'detalle_permisos.id')
            ->where('Detalle_permisos.habilitado', '=', 'S')
            ->get();

        return response()->json([
            'dataDB' => $detalle,
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
            ->select('detalle_permisos.documento_id', 'permisos.tipoPermiso_id', 'permisos.id AS permiso_id', 'detalle_permisos.departamento_id', 'departamentos.nombre', 'detalle_permisos.colaborador_id', 'users.nombres', 'users.apellidos', 'detalle_permisos.created_at', 'detalle_permisos.id')
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
    public function edit(Request $request)
    {
        $tipoDoc = DetallePermiso::findOrFail($request->id)->update([
            'habilitado' => 'N'
        ]);
        return response()->json([
            'dataDB' => $tipoDoc,
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
        // if($request->id) {
        //     $documento = DetallePermiso::find($request->id);
        //     $documento->update([
        //         'permiso_id' => $request->permiso_id,
        //         'documento_id' => $request->documento_id,
        //         'departamento_id' => $request->departamento_id,
        //         'colaborador_id' => $request->colaborador_id,
        //         'updated_at' => $request->fechaRegistro,
        //         // 'habilitado' => 'S',

        //         // 'permiso_id': this.idP,
        //         // 'documento_id': this.idD,
        //         // 'tipoPermiso_id': tipo.value,
        //         // 'departamento_id': idDepar,
        //         // 'colaborador_id': idColab,
        //         // 'fechaRegistro': today,
        //     ]);
        // }

        if($request->documento_id) {
            // Paso 1: Obtener los nuevos usuarios_id
            $nuevosPermisosUserId = $request->input('colaborador_id');
            
            $cadenas = $nuevosPermisosUserId;
            $array = explode(',', $cadenas);
            $numeros = array_map('intval', $array);

            // Paso 2: Recuperar los registros existentes
            $registrosExistente = DetallePermiso::where('documento_id', $request->documento_id)->get();
        
            // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
            $colaboradoresIdExistente = $registrosExistente->pluck('colaborador_id')->toArray();
            $colaboradoresIdEliminar = array_diff($colaboradoresIdExistente, $numeros);
            $colaboraoresIdAgregar = array_diff($numeros, $colaboradoresIdExistente);

            //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
            DetallePermiso::where('documento_id', $request->documento_id)
                            ->whereIn('colaborador_id', $colaboradoresIdEliminar)
                            ->delete();

            // Paso 5: Agregar los nuevos registros para los usuarios_id que no están en los registros existentes
            foreach ($colaboraoresIdAgregar as $usersId) {
                $detalle = new DetallePermiso();
                $detalle->colaborador_id = $usersId;
                $detalle->departamento_id = null;
                $detalle->documento_id = $request->documento_id;
                $detalle->permiso_id = $registrosExistente[0]->permiso_id;
                $detalle->habilitado = 'S';
                $detalle->save();
            }

            return response()->json([
                'success' => true
            ], 201);
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
}
