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
        ->where('grupo_evaluaciones.habilitado', '=', 'S')
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
    public function update(Request $request)
    {
        
        // Paso 1: Obtener los nuevos usuarios_id
        $nuevosUsuariosId = $request->input('colaborador_id');
        $cadenas = $nuevosUsuariosId;
        $array = explode(',', $cadenas);
        $numeros = array_map('intval', $array);

        // Paso 2: Recuperar los registros existentes
        $registrosExistente = DetalleGrupoEvaluaciones::where('grupo_id', $request->grupo_id)->get();
     
        // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
        $usuariosIdExistente = $registrosExistente->pluck('colaborador_id')->toArray();
        $usuariosIdEliminar = array_diff($usuariosIdExistente, $numeros);
        $usuariosIdAgregar = array_diff($numeros, $usuariosIdExistente);

        // Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
        DetalleGrupoEvaluaciones::where('grupo_id', $request->grupo_id)
            ->whereIn('colaborador_id', $usuariosIdEliminar)
            ->delete();

        // Paso 5: Agregar los nuevos registros para los usuarios_id que no están en los registros existentes
        foreach ($usuariosIdAgregar as $usuarioId) {
            $detalleGrupo = new DetalleGrupoEvaluaciones();
            $detalleGrupo->grupo_id = $request->grupo_id;
            $detalleGrupo->colaborador_id = $usuarioId;
            $detalleGrupo->evaluacion_id = $registrosExistente[0]->evaluacion_id;
            $detalleGrupo->habilitado = 'S';
            $detalleGrupo->save();
        }
        
        return response()->json([
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
