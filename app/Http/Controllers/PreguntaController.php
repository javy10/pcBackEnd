<?php

namespace App\Http\Controllers;

use App\Models\DetalleEvaluacionPregunta;
use App\Models\TipoPregunta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\DetallePreguntaRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // return $request;
        // die;

        // Recorremos el array con un bucle foreach
        foreach ($request->all() as $item) {
            $pregunta = new Pregunta();
            $pregunta->valorPregunta = $item['pregunta'];
            $pregunta->tipoPregunta_id = $item['tipoPregunta_id'];
            $pregunta->habilitado = 'S';
            $pregunta->save();
        
            foreach ($item['respuestas'] as $resp) {

                $respuestas = new Respuesta();
                $respuestas->valorRespuesta = $resp['respuesta'];
                $respuestas->respuestaCorrecta = $resp['seleccionado'];
                $respuestas->habilitado = 'S';
                $respuestas->save();

                $detalle = new DetallePreguntaRespuesta();
                $detalle->pregunta_id = $pregunta->id;
                $detalle->respuesta_id = $respuestas->id;
                $detalle->habilitado = 'S';
                $detalle->save();
            }

            $detalle = new DetalleEvaluacionPregunta();
            $detalle->pregunta_id = $pregunta->id;
            $detalle->evaluacion_id = $item['evaluacion_id'];
            $detalle->nota = null;
            $detalle->habilitado = 'S';
            $detalle->save();
        }

        return response()->json([
            'success' => true
        ], 201);

        // $pregunta = new Pregunta();
        // $pregunta->valorPregunta = $request->pregunta;
        // $pregunta->tipoPregunta_id = $request->tipoPregunta_id;
        // $pregunta->habilitado = 'S';
        // $pregunta->save();
    
        // foreach ($request->respuestas as $resp) {

        //     $respuestas = new Respuesta();
        //     $respuestas->valorRespuesta = $resp['respuesta'];
        //     $respuestas->respuestaCorrecta = $resp['seleccionado'];
        //     $respuestas->habilitado = 'S';
        //     $respuestas->save();

        //     $detalle = new DetallePreguntaRespuesta();
        //     $detalle->pregunta_id = $pregunta->id;
        //     $detalle->respuesta_id = $respuestas->id;
        //     $detalle->habilitado = 'S';
        //     $detalle->save();
        // }

        // $detalle = new DetalleEvaluacionPregunta();
        // $detalle->pregunta_id = $pregunta->id;
        // $detalle->evaluacion_id = $request->evaluacion_id;
        // $detalle->nota = null;
        // $detalle->habilitado = 'S';
        // $detalle->save();

    }
    public function crearPreguntasAbiertas(Request $request)
    {

        // return $request;
        // die;

        // Recorremos el array con un bucle foreach
        foreach ($request->all() as $item) {

            // return $item['pregunta'];
            // die;
        
            $pregunta = new Pregunta();
            $pregunta->valorPregunta = $item['pregunta'];
            $pregunta->tipoPregunta_id = $item['tipoPregunta_id'];
            $pregunta->habilitado = 'S';
            $pregunta->save();
        
            // foreach ($item['respuestas'] as $resp) {

            //     $respuestas = new Respuesta();
            //     $respuestas->valorRespuesta = $resp['respuesta'];
            //     $respuestas->respuestaCorrecta = $resp['seleccionado'];
            //     $respuestas->habilitado = 'S';
            //     $respuestas->save();

            //     $detalle = new DetallePreguntaRespuesta();
            //     $detalle->pregunta_id = $pregunta->id;
            //     $detalle->respuesta_id = $respuestas->id;
            //     $detalle->habilitado = 'S';
            //     $detalle->save();
            // }

            $detalle = new DetalleEvaluacionPregunta();
            $detalle->pregunta_id = $pregunta->id;
            $detalle->evaluacion_id = $item['evaluacion_id'];
            $detalle->nota = null;
            $detalle->habilitado = 'S';
            $detalle->save();
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
        //
        $result = DB::table('detalle_evaluacion_preguntas')
                ->join('preguntas', 'detalle_evaluacion_preguntas.pregunta_id', '=', 'preguntas.id')
                ->select('preguntas.id', 'preguntas.valorPregunta')
                ->where('preguntas.habilitado', '=', 'S')
                ->where('detalle_evaluacion_preguntas.evaluacion_id', '=', $request->id)
                ->get();

        return response()->json([
            'dataDB' => $result,
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
        if($request->id) {

            $evaluacion = Pregunta::where('id', $request->id)->update([
                'valorPregunta' => $request->valorPregunta
            ]);
            return response()->json([
                // 'dataDB' => $documentos,
                'success' => true
            ]);
        }
    }
    public function deshabilitarPregunta(Request $request)
    {
        if($request->id) {

            $evaluacion = Pregunta::where('id', $request->id)->update([
                'habilitado' => 'N'
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
