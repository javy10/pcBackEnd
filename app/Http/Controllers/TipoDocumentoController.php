<?php

namespace App\Http\Controllers;

use App\Models\tipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$tipoDocumento = tipoDocumento::all();
        $tipoDocumento = tipoDocumento::where('habilitado', 'S')->get();
        return $tipoDocumento;

    }

    public function buscarTipo(Request $request)
    {
        //
        //$tipoDocumento = tipoDocumento::all();
        // $tipoDocumento = tipoDocumento::where('habilitado', 'S')->get();
        // return $tipoDocumento;

        // return $request;
        // die;

        $documentos = DB::table('tipo_documentos')
            ->join('documentos', 'documentos.tipoDocumento_id', '=', 'tipo_documentos.id')
            ->join('detalle_permisos','detalle_permisos.documento_id','=','documentos.id')
            ->select('tipo_documentos.tipo', 'tipo_documentos.id')
            ->where('tipo_documentos.habilitado','=','S')
            ->Where('detalle_permisos.colaborador_id','=', $request->idC)
            ->orWhere('detalle_permisos.departamento_id','=', $request->idD)
            ->get();
        return response()->json([
            'dataDB' => $documentos,
            'success' => true
        ]);
        
    }

    public function tipoDocumentos()
    {
        //
        $tipoDocumento = tipoDocumento::all();
        //$tipoDocumento = tipoDocumento::where('habilitado', 'S')->get();
        return $tipoDocumento;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        //return $request->tipo;
        $tipo = tipoDocumento::create([
            'tipo' => $request->tipo,
            'habilitado' => 'S'
        ]);
        
         return response()->json([
             'tipo' => $tipo,
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
        $tipo = tipoDocumento::find($request->id);
        return response()->json([
            'dataDB' => $tipo,
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
        $tipoDoc = tipoDocumento::findOrFail($request->id)->update([
            'habilitado' => 'N'
        ]);
        return response()->json([
            'dataDB' => $tipoDoc,
            'success' => true
        ]);
    }

    public function desbloquear(Request $request)
    {
        $tipo = tipoDocumento::findOrFail($request->id)->update([
            'habilitado' => 'S'
        ]);
        return response()->json([
            'dataDB' => $tipo,
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
        
        $tipo = tipoDocumento::find($request->id);
        $tipo->update([
            'tipo' => $request->tipo
        ]);
        return response()->json([
            'dataDB' => $tipo,
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
