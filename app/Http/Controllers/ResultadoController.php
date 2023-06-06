<?php

namespace App\Http\Controllers;

use App\Models\DetalleEvaluacionResultado;
use App\Models\Resultado;
use Illuminate\Http\Request;

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
        }
        if($request->respuestaSeleccionada != null){
            $ultimoId = Resultado::latest('id')->first()->id;
            foreach ($request->respuestaSeleccionada as $resp) {

                $detalleResult = new DetalleEvaluacionResultado();
                $detalleResult->pregunta_id = $request->pregunta;
                $detalleResult->respuesta_id = $resp;
                $detalleResult->resultado_id = $ultimoId;
                $detalleResult->habilitado = 'S';
                $detalleResult->save();
            }
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
