<?php

namespace App\Http\Controllers;

use App\Models\DetalleGrupoEvaluaciones;
use App\Models\Evaluaciones;
use App\Models\GrupoEvaluaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { //'detalle_grupo_evaluaciones.colaborador_id as colaborador_id', 
        // $evaluaciones = DB::table('evaluaciones')
        //                     ->select('evaluaciones.id', 'evaluaciones.nombre', 'evaluaciones.descripcion', 'evaluaciones.cantidadPreguntas', 'detalle_grupo_evaluaciones.intentos', 'evaluaciones.created_at')
        //                     ->distinct()
        //                     ->join('detalle_grupo_evaluaciones', 'detalle_grupo_evaluaciones.evaluacion_id', '=', 'evaluaciones.id')
        //                     ->join('grupo_evaluaciones', 'detalle_grupo_evaluaciones.grupo_id', '=', 'grupo_evaluaciones.id')
        //                     ->where('evaluaciones.habilitado', '=', 'S')
        //                     ->get();

        $evaluaciones = Evaluaciones::selectRaw('COUNT(DISTINCT detalle_grupo_evaluaciones.grupo_id) AS grupo, evaluaciones.id, evaluaciones.nombre, evaluaciones.descripcion, evaluaciones.cantidadPreguntas, detalle_grupo_evaluaciones.intentos, evaluaciones.created_at')
                    ->join('detalle_grupo_evaluaciones', 'detalle_grupo_evaluaciones.evaluacion_id', '=', 'evaluaciones.id')
                    ->join('grupo_evaluaciones', 'detalle_grupo_evaluaciones.grupo_id', '=', 'grupo_evaluaciones.id')
                    ->where('evaluaciones.habilitado', '=', 'S')
                    ->where('grupo_evaluaciones.habilitado', '=', 'S')
                    ->groupBy('evaluaciones.id')
                    ->get();

        return response()->json([
            'dataDB' => $evaluaciones,
            'success' => true
        ], 201);
    }

    public function obtenerEvaluacionesDeshabilitadas()
    {
        $evaluaciones = DB::table('evaluaciones')
            ->select('grupo_evaluaciones.nombre as grupo', 'evaluaciones.id', 'evaluaciones.nombre', 'evaluaciones.descripcion', 'evaluaciones.cantidadPreguntas', 'evaluaciones.intentos', 'evaluaciones.created_at')
            ->distinct()
            ->join('detalle_grupo_evaluaciones', 'detalle_grupo_evaluaciones.evaluacion_id', '=', 'evaluaciones.id')
            ->join('grupo_evaluaciones', 'detalle_grupo_evaluaciones.grupo_id', '=', 'grupo_evaluaciones.id')
            ->where('evaluaciones.habilitado', '=', 'N')
            ->get();

        return response()->json([
            'dataDB' => $evaluaciones,
            'success' => true
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // return $request->grupos;
        // die;
        // $evaluacion = new Evaluaciones();
        // $evaluacion->nombre = $request->nombreE;
        // $evaluacion->descripcion = $request->descripcion;
        // $evaluacion->calificacionMinima = $request->calificacionMinima;
        // $evaluacion->intentos = $request->intentos;
        // $evaluacion->cantidadPreguntas = 0;
        // $evaluacion->habilitado = 'S';
        // $evaluacion->save();

        // return response()->json([
        //     'success' => true
        // ], 201);

        $evaluacion = new Evaluaciones();
        $evaluacion->nombre = $request->nombre;
        $evaluacion->descripcion = $request->descripcion;
        $evaluacion->calificacionMinima = $request->calificacionMinima;
        $evaluacion->intentos = $request->intentos;
        $evaluacion->cantidadPreguntas = 0;
        $evaluacion->habilitado = 'S';
        $evaluacion->save();

        $myArray = json_decode($request->grupos);

        foreach ($myArray as $item) {
            $grupo = new GrupoEvaluaciones();
            $grupo->nombre = $item->nombre;
            $grupo->apertura = $item->apertura;
            $grupo->cierre = $item->cierre;
            $grupo->habilitado = 'S';
            $grupo->save();

            foreach ($item->usuarios as $user) {
                $detalleGE = new DetalleGrupoEvaluaciones();
                $detalleGE->grupo_id = $grupo->id;
                $detalleGE->evaluacion_id = $evaluacion->id;
                $detalleGE->colaborador_id = $user;
                $detalleGE->intentos = $item->intentos;
                $detalleGE->habilitado = 'S';
                $detalleGE->save();
            }
        }

        return response()->json([
            'success' => true
        ], 201);
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
        $evaluacion = Evaluaciones::find($request->id);
        return response()->json([
            'dataDB' => $evaluacion,
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
        
        if($request->evaluacion_id) {

            $evaluacion = Evaluaciones::where('id', $request->evaluacion_id)->update([
                'cantidadPreguntas' => $request->conteo
            ]);
            return response()->json([
                // 'dataDB' => $documentos,
                'success' => true
            ]);
        }
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

        $evaluacion = Evaluaciones::find($request->evaluacion_id);

        if (!$evaluacion) {
            return response()->json([
                'dataDB' => 'Evaluacion no encontrada',
                'success' => false
            ], 404);
        } else {

            $evaluacion->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'calificacionMinima' => $request->calificacionMinima,
                'intentos' => $request->intentos
            ]);

            $myArray = json_decode($request->grupos);

            foreach ($myArray as $item) {

                $grupo = GrupoEvaluaciones::find($item->id);
                $grupo->update([
                    'nombre' => $item->nombreG,
                    'apertura' => $item->apertura,
                    'cierre' => $item->cierre
                ]);

                // Paso 1: Obtener los nuevos usuarios_id
                $nuevosPermisosUserId = $item->usuarios;
                $cadenas = $nuevosPermisosUserId;
                $numeros = array_map('intval', $cadenas);
                
                // Paso 2: Recuperar los registros existentes
                $registrosExistente = DetalleGrupoEvaluaciones::where('grupo_id', $item->id)->get();
                
                // return $registrosExistente;
                // die;

                // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
                $colaboradoresIdExistente = $registrosExistente->pluck('colaborador_id')->toArray();
                $colaboradoresIdEliminar = array_diff($colaboradoresIdExistente, $numeros);
                $colaboraoresIdAgregar = array_diff($numeros, $colaboradoresIdExistente);

                // return $colaboradoresIdEliminar;
                // die;
    
                //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
                DetalleGrupoEvaluaciones::where('grupo_id', $item->id)
                                ->whereIn('colaborador_id', $colaboradoresIdEliminar)
                                ->delete();

                // Paso 5: Agregar los nuevos registros para los usuarios_id que no están en los registros existentes
                foreach ($colaboraoresIdAgregar as $usersId) {
                    $detalle = new DetalleGrupoEvaluaciones();
                    $detalle->colaborador_id = $usersId;
                    $detalle->grupo_id = $item->id;
                    $detalle->evaluacion_id = $evaluacion->id;
                    $detalle->intentos = $item->intentos;
                    $detalle->habilitado = 'S';
                    $detalle->save();
                }
            }
            
            return response()->json([
                // 'dataDB' => $evaluacion,
                'success' => true
            ], 200);
        }

    }

    public function deshabilitarEvaluacion(Request $request)
    {
        //
        $evaluacion = Evaluaciones::findOrFail($request->id)->update([
            'habilitado' => 'N'
        ]);
        return response()->json([
            'dataDB' => $evaluacion,
            'success' => true
        ]);
    }

    public function editarIntentosEvaluacion(Request $request)
    {

        
        // $evaluacion = DB::table('detalle_grupo_evaluaciones')
        //         ->where('detalle_grupo_evaluaciones.evaluacion_id', $request->evaluacion_id)
        //         ->where('detalle_grupo_evaluaciones.colaborador_id', $request->colaborador_id)
        //         ->decrement('intentos');
                
        $evaluacion = DetalleGrupoEvaluaciones::where('colaborador_id', $request->colaborador_id)
                                                ->where('evaluacion_id', $request->evaluacion_id)
                                                ->firstOrFail();

        // Decrementar el valor del campo "intentos" en 1
        $evaluacion->intentos--;
        // Guardar los cambios en la tabla
        $evaluacion->save();
        return response()->json([
            'dataDB' => $evaluacion,
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
