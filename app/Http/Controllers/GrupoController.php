<?php

namespace App\Http\Controllers;

use App\Models\GrupoEvaluaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrupoController extends Controller
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
        $grupo = new GrupoEvaluaciones();
        $grupo->nombre = $request->nombre;
        $grupo->apertura = $request->apertura;
        $grupo->cierre = $request->cierre;
        $grupo->habilitado = 'S';
        $grupo->save();

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
        $resultados = DB::table('detalle_grupo_evaluaciones')
        ->select('colaborador_id')
        ->where('grupo_id', '=', $request->id)
        ->get();

        return response()->json([
            'dataDB' => $resultados,
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

        $grupo = GrupoEvaluaciones::find($request->id);
        return response()->json([
            'dataDB' => $grupo,
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
        //
        $grupo = GrupoEvaluaciones::findOrFail($request->id)->update([
            'habilitado' => 'N'
        ]);
        return response()->json([
            'dataDB' => $grupo,
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
        $grupo = GrupoEvaluaciones::find($request->grupo_id);

        if (!$grupo) {
            return response()->json([
                'message' => 'Grupo no encontrado',
                'success' => false
            ], 404);
        }

        $grupo->nombre = $request->input('nombre');
        $grupo->apertura = $request->input('apertura');
        $grupo->cierre = $request->input('cierre');
        $grupo->save();

        return response()->json([
            'message' => 'Grupo actualizado con éxito',
            'success' => true
        ], 200);
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
