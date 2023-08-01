<?php

namespace App\Http\Controllers;

use App\Models\DetallePermiso;
use App\Models\Permiso;
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
                    ->select('colaborador_id', 'departamento_id', 'cargo_id')
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

        if($request->documento_id) {
            // Paso 1: Obtener los nuevos usuarios_id
            $nuevosPermisosDepartId = $request->input('departamento_id');
            $cadenasD = $nuevosPermisosDepartId;
            $arrayD = explode(',', $cadenasD);
            $numerosD = array_map('intval', $arrayD);
//************************************************************************************************************* */
            // Paso 1: Obtener los nuevos usuarios_id
            $nuevosPermisosCargoId = $request->input('cargo_id');
            $cadenasC = $nuevosPermisosCargoId;
            $arrayC = explode(',', $cadenasC);
            $numerosC = array_map('intval', $arrayC);
 //************************************************************************************************************* */
            // Paso 1: Obtener los nuevos usuarios_id
            $nuevosPermisosUserId = $request->input('colaborador_id');
            $cadenas = $nuevosPermisosUserId;
            $array = explode(',', $cadenas);
            $numeros = array_map('intval', $array);
 //************************************************************************************************************* */
            // Paso 2: Recuperar los registros existentes
            $registrosExistente = DetallePermiso::where('documento_id', $request->documento_id)->get();
            
            //************************************************************************************************************* */
            // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
            $departamentosIdExistente = $registrosExistente->pluck('departamento_id')->toArray();
            $filteredArrayD = array_filter($departamentosIdExistente, function ($value) {
                return $value !== null;
            });
            $departamentosIdEliminar = array_diff($filteredArrayD, $numerosD);
            $departamentosIdAgregar = array_diff($numerosD, $filteredArrayD);

            // return $registrosExistente;
            // die;

            //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
            if(!empty($departamentosIdEliminar)){
                DetallePermiso::where('documento_id', $request->documento_id)
                                ->whereIn('departamento_id', $departamentosIdEliminar)
                                ->delete();
            }
            //************************************************************************************************************* */
            // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
            $cargosIdExistente = $registrosExistente->pluck('cargo_id')->toArray();
            $filteredArrayC = array_filter($cargosIdExistente, function ($value) {
                return $value !== null;
            });
            $cargosIdEliminar = array_diff($filteredArrayC, $numerosC);
            $cargosIdAgregar = array_diff($numerosC, $filteredArrayC);
            //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
            if(!empty($cargosIdEliminar)){
                DetallePermiso::where('documento_id', $request->documento_id)
                                ->whereIn('cargo_id', $cargosIdEliminar)
                                ->delete();
            }
            //************************************************************************************************************* */
            // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
            $colaboradoresIdExistente = $registrosExistente->pluck('colaborador_id')->toArray();
            $filteredArray = array_filter($colaboradoresIdExistente, function ($value) {
                return $value !== null;
            });
            $colaboradoresIdEliminar = array_diff($filteredArray, $numeros);
            $colaboraoresIdAgregar = array_diff($numeros, $filteredArray);
            //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
            if(!empty($colaboradoresIdEliminar)){
                DetallePermiso::where('documento_id', $request->documento_id)
                                ->whereIn('colaborador_id', $colaboradoresIdEliminar)
                                ->delete();
            }
            //************************************************************************************************************* */   

            //return $departamentosIdAgregar;
            //return $cargosIdAgregar;
            //return $colaboraoresIdAgregar;
            //die;

            // Paso 5: Agregar los nuevos registros para los usuarios_id que no están en los registros existentes
            if(!empty(array_diff($departamentosIdAgregar, [0]))) {

                // return 'entro';
                // die;

                $permiso = new Permiso();
                $permiso->tipoPermiso_id = $request->tipoPermisoD_id;
                $permiso->habilitado = 'S';
                $permiso->save();
                foreach ($departamentosIdAgregar as $departamentoId) {
                    $detalle = new DetallePermiso();
                    $detalle->departamento_id = $departamentoId;
                    $detalle->cargo_id = null;
                    $detalle->colaborador_id = null;
                    $detalle->documento_id = $request->documento_id;
                    //$detalle->permiso_id = $registrosExistente[0]->permiso_id;
                    $detalle->permiso_id = $permiso->id;
                    $detalle->habilitado = 'S';
                    $detalle->save();
                }
            }
            if(!empty(array_diff($cargosIdAgregar, [0]))) {
                $permiso = new Permiso();
                $permiso->tipoPermiso_id = $request->tipoPermisoC_id;
                $permiso->habilitado = 'S';
                $permiso->save();
                foreach ($cargosIdAgregar as $cargoId) {
                    $detalle = new DetallePermiso();
                    $detalle->departamento_id = null;
                    $detalle->cargo_id = $cargoId;
                    $detalle->colaborador_id = null;
                    $detalle->documento_id = $request->documento_id;
                    // $detalle->permiso_id = $registrosExistente[0]->permiso_id;
                    $detalle->permiso_id = $permiso->id;
                    $detalle->habilitado = 'S';
                    $detalle->save();
                }
            }
            if(!empty(array_diff($colaboraoresIdAgregar, [0]))) {
                $permiso = new Permiso();
                $permiso->tipoPermiso_id = $request->tipoPermiso_id;
                $permiso->habilitado = 'S';
                $permiso->save();
                foreach ($colaboraoresIdAgregar as $usersId) {
                    $detalle = new DetallePermiso();
                    $detalle->departamento_id = null;
                    $detalle->cargo_id = null;
                    $detalle->colaborador_id = $usersId;
                    $detalle->documento_id = $request->documento_id;
                    // $detalle->permiso_id = $registrosExistente[0]->permiso_id;
                    $detalle->permiso_id = $permiso->id;
                    $detalle->habilitado = 'S';
                    $detalle->save();
                }
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
