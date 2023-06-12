<?php

namespace App\Http\Controllers;

use App\Models\DetalleEvaluacionPregunta;
use App\Models\Evaluaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleEvaluacionPreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request->id;
        // die;

        $resultados = DB::table('preguntas as p')
                        ->join('detalle_pregunta_respuestas as pr', 'p.id', '=', 'pr.pregunta_id')
                        ->join('respuestas as r', 'pr.respuesta_id', '=', 'r.id')
                        ->join('detalle_evaluacion_preguntas as dep', 'p.id', '=', 'dep.pregunta_id')
                        ->join('evaluaciones as e', 'dep.evaluacion_id', '=', 'e.id')
                        ->join('detalle_grupo_evaluaciones as dge', 'e.id', '=', 'dge.evaluacion_id')
                        ->join('grupo_evaluaciones as g', 'dge.grupo_id', '=', 'g.id')
                        ->select('p.id', 'p.valorPregunta', 'r.id as respuesta_id', 'r.valorRespuesta', 'p.tipoPregunta_id', 'e.id as evaluacion_id', 'e.nombre' )
                        ->distinct()
                        ->where('g.habilitado', '=', 'S')
                        ->where('e.habilitado', '=', 'S')
                        // ->where('r.respuestaCorrecta', '=', 1)
                        ->where('dge.colaborador_id', '=', $request->colaborador_id)
                        ->where('e.id', '=', $request->evaluacion_id)
                        // ->groupBy('p.valorPregunta')
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
    public function show($id)
    {
        $conteo = DetalleEvaluacionPregunta::where('evaluacion_id', '=', $id)
            ->count('pregunta_id');

        $grupo = Evaluaciones::findOrFail($id)->update([
            'cantidadPreguntas' => $conteo
        ]);

        return response()->json([
            'conteo' => $conteo,
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
