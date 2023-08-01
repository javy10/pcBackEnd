<?php

namespace App\Http\Controllers;

use App\Models\DetalleEvaluacionResultado;
use App\Models\DetallePreguntaRespuesta;
use App\Models\DetallePreguntasRespuestasAbiertas;
use App\Models\Respuesta;
use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {     
        if($request->evaluacion_id != null){
            $result = new Resultado();
            $result->colaborador_id = $request->colaborador_id;
            $result->evaluacion_id = $request->evaluacion_id;
            $result->resultado = $request->resultado;
            $result->habilitado = 'S';
            $result->save();

            DB::table('detalle_grupo_evaluaciones')
            ->where('evaluacion_id', '=', $request->evaluacion_id)
            ->where('colaborador_id', '=', $request->colaborador_id)
            ->update(['finalizada' => 'S']);

            if(!empty($request->subArreglos)) {
                foreach ($request->subArreglos as $item) {
                    $pregunta = $item['pregunta'];
                    $respuestaSeleccionada = $item['respuestaSeleccionada'];
    
                    foreach ($respuestaSeleccionada as $resp){
                        $detalleResult = new DetalleEvaluacionResultado();
                        $detalleResult->pregunta_id = $pregunta;
                        $detalleResult->respuesta_id = $resp;
                        $detalleResult->resultado_id = $result->id;
                        $detalleResult->habilitado = 'S';
                        $detalleResult->save();
                    }
                }
                return response()->json([
                    'success' => true
                ], 201);
            }
        }
    }

    public function ResultadosPreguntasAbiertas(Request $request)
    {     

        // return $request;
        // die;

        if($request->evaluacion_id != null){
         
            // DB::table('respuestas')
            // ->where('id', '=', $request->respuesta_id)
            // ->update(['valorRespuesta' => $request->valorRespuesta]);

            $respuestas = new Respuesta();
            $respuestas->valorRespuesta = $request->valorRespuesta;
            $respuestas->respuestaCorrecta = null;
            $respuestas->habilitado = 'S';
            $respuestas->save();

            $detalle = new DetallePreguntaRespuesta();
            $detalle->pregunta_id = $request->preguntaId;
            $detalle->respuesta_id = $respuestas->id;
            $detalle->habilitado = 'S';
            $detalle->save();
        

            $detalleResultado = new DetallePreguntasRespuestasAbiertas();
            $detalleResultado->evaluacion_id = $request->evaluacion_id;
            $detalleResultado->pregunta_id = $request->preguntaId;
            $detalleResultado->respuesta_id = $respuestas->id;
            $detalleResultado->habilitado = 'S';
            $detalleResultado->save();

            DB::table('detalle_grupo_evaluaciones')
            ->where('evaluacion_id', '=', $request->evaluacion_id)
            ->where('colaborador_id', '=', $request->colaborador_id)
            ->update(['finalizada' => 'S']);
            
            return response()->json([
                'success' => true
            ], 201);
        }
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
        //
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
