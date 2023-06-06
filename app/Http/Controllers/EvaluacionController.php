<?php

namespace App\Http\Controllers;

use App\Models\Evaluaciones;
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
    {
        $evaluaciones = Evaluaciones::select('grupo_evaluaciones.nombre as grupo', 'evaluaciones.id', 'evaluaciones.nombre', 'evaluaciones.descripcion', 'evaluaciones.cantidadPreguntas', 'evaluaciones.intentos', 'evaluaciones.created_at')
            ->distinct()
            ->join('detalle_grupo_evaluaciones', 'detalle_grupo_evaluaciones.evaluacion_id', '=', 'evaluaciones.id')
            ->join('grupo_evaluaciones', 'detalle_grupo_evaluaciones.grupo_id', '=', 'grupo_evaluaciones.id')
            ->where('evaluaciones.habilitado', '=', 'S')
            ->get();

        return response()->json([
            'dataDB' => $evaluaciones,
            'success' => true
        ], 201);
    }

    public function obtenerEvaluacionesDeshabilitadas()
    {
        $evaluaciones = Evaluaciones::select('grupo_evaluaciones.nombre as grupo', 'evaluaciones.id', 'evaluaciones.nombre', 'evaluaciones.descripcion', 'evaluaciones.cantidadPreguntas', 'evaluaciones.intentos', 'evaluaciones.created_at')
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
        $evaluacion = new Evaluaciones();
        $evaluacion->nombre = $request->nombre;
        $evaluacion->descripcion = $request->descripcion;
        $evaluacion->calificacionMinima = $request->calificacionMinima;
        $evaluacion->intentos = $request->intentos;
        $evaluacion->cantidadPreguntas = 0;
        $evaluacion->habilitado = 'S';
        $evaluacion->save();

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
                'message' => 'Evaluacion no encontrada',
                'success' => false
            ], 404);
        }

        $evaluacion->nombre = $request->input('nombre');
        $evaluacion->descripcion = $request->input('descripcion');
        $evaluacion->calificacionMinima = $request->input('calificacionMinima');
        $evaluacion->intentos = $request->input('intentos');
        $evaluacion->save();

        return response()->json([
            'message' => 'Evaluacion actualizada con éxito',
            'success' => true
        ], 200);
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

        
        $evaluacion = DB::table('detalle_grupo_evaluaciones')
                ->where('detalle_grupo_evaluaciones.evaluacion_id', $request->evaluacion_id)
                ->where('detalle_grupo_evaluaciones.colaborador_id', $request->colaborador_id)
                ->decrement('intentos',1);
                //->update(['intentos' => 0]);

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
