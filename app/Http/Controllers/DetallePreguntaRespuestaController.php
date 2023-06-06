<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallePreguntaRespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resultados = DB::table('detalle_pregunta_respuestas as dpr')
                        ->join('respuestas as r', 'dpr.respuesta_id', '=', 'r.id')
                        ->join('preguntas as p', 'dpr.pregunta_id', '=', 'p.id')
                        ->select('r.id as respuesta_id', 'r.valorRespuesta', 'p.id as pregunta_id', 'p.tipoPregunta_id', 'r.respuestaCorrecta')
                        ->where('r.respuestaCorrecta', '=', 1)
                        ->where('dpr.pregunta_id', '=', $request->id)
                        ->get();

        return response()->json([
            'dataDB' => $resultados,
            'success' => true
        ], 201);
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
        $respuestaCorrecta = DB::table('detalle_pregunta_respuestas')
                            ->join('preguntas', 'detalle_pregunta_respuestas.pregunta_id', '=', 'preguntas.id')
                            ->join('respuestas', 'detalle_pregunta_respuestas.respuesta_id', '=', 'respuestas.id')
                            ->select('respuestas.id')
                            ->where('preguntas.id', '=', $request->pregunta_id)
                            ->where('respuestas.respuestaCorrecta', '=', 1)
                            ->get();
        return response()->json([
            'dataDB' => $respuestaCorrecta,
            'success' => true
        ], 201);

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
