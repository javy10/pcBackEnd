<?php

namespace App\Http\Controllers;

use App\Models\cargo;
use App\Models\departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class cargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = cargo::all()->where('habilitado', '=', 'S');
        return $cargos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cargo = new cargo();
        $cargo->nombre = $request->nombre;
        $cargo->departamento_id = $request->departamento_id;
        $cargo->habilitado = 'S';
        // $cargo->created_at = $request->fechaRegistro;
        $cargo->save();

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

    public function show(Request $depart)
    {
        $cargo = DB::table('cargos')
                ->distinct()
                ->select('cargos.id', 'cargos.nombre')
                ->join('departamentos', 'cargos.departamento_id', '=', 'departamentos.id')
                ->where('cargos.departamento_id', $depart->id)
                ->where('cargos.habilitado', '=', 'S')
                ->get();
        return response()->json([
            'dataDB' => $cargo,
            'success' => true
        ]);
    }

    public function buscar(Request $request)
    {
        $colab = cargo::find($request->id);
        return response()->json([
            'dataDB' => $colab,
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
        $cargo = cargo::findOrFail($request->id)->update([
            'habilitado' => 'N'
        ]);
        return response()->json([
            // 'dataDB' => $colaborador,
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
