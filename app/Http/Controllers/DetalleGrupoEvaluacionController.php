<?php

namespace App\Http\Controllers;

use App\Models\DetalleGrupoEvaluaciones;
use App\Models\Evaluaciones;
use App\Models\GrupoEvaluaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleGrupoEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultados = DB::table('detalle_grupo_evaluaciones')
        ->join('grupo_evaluaciones', 'detalle_grupo_evaluaciones.grupo_id', '=', 'grupo_evaluaciones.id')
        ->select(
            'detalle_grupo_evaluaciones.grupo_id',
            'grupo_evaluaciones.nombre',
            DB::raw('COUNT(detalle_grupo_evaluaciones.colaborador_id) as colaboradores'),
            'grupo_evaluaciones.apertura',
            'grupo_evaluaciones.cierre',
            'grupo_evaluaciones.created_at',
            'grupo_evaluaciones.updated_at'
        )
        ->groupBy('detalle_grupo_evaluaciones.grupo_id', 'grupo_evaluaciones.nombre', 'grupo_evaluaciones.apertura', 'grupo_evaluaciones.cierre', 'grupo_evaluaciones.created_at', 'grupo_evaluaciones.updated_at')
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
    public function create(Request $request)
    {
        //$documento = new Documento();
        $ultimoId = GrupoEvaluaciones::latest()->first()->id;

        $detalleGE = new DetalleGrupoEvaluaciones();
        $detalleGE->grupo_id = $ultimoId;
        $detalleGE->evaluacion_id = $request->evaluacion_id == 0 ? null : $request->evaluacion_id;
        $detalleGE->colaborador_id = $request->colaborador_id;
        $detalleGE->habilitado = 'S';
        $detalleGE->save();

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
    public function edit(Request $request)
    {
        if($request->grupo_id) {
            $ultimoId = Evaluaciones::latest()->first()->id;
            $evaluacion = DetalleGrupoEvaluaciones::where('grupo_id', $request->grupo_id)->update([
                'evaluacion_id' => $ultimoId
            ]);
            return response()->json([
                'evaluacion' => $evaluacion,
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
