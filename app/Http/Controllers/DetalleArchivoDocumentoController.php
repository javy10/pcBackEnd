<?php

namespace App\Http\Controllers;

use App\Models\DetalleArchivoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleArchivoDocumentoController extends Controller
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
    public function show()
    {
        
        $documentos = DB::table('documentos')
            ->join('detalle_archivo_documentos', 'detalle_archivo_documentos.documento_id', '=', 'documentos.id')
            ->join('permisos', 'permisos.documento_id','=','documentos.id')
            ->join('detalle_permisos','detalle_permisos.permiso_id','=','permisos.id')
            ->select('documentos.tipoDocumento_id', 'detalle_archivo_documentos.nombreArchivo', 'permisos.tipoPermiso_id', 'permisos.documento_id', 'detalle_permisos.departamento_id', 'detalle_permisos.colaborador_id', 'detalle_archivo_documentos.fechaLimite')
            ->where('documentos.habilitado','=','S')
            ->get();
        // $documentos = DB::table('detalle_archivo_documentos')
        //     ->join('documentos', 'detalle_archivo_documentos.documento_id', '=', 'documentos.id')
        //     ->select('documentos.tipoDocumento_id', 'detalle_archivo_documentos.nombreArchivo', 'documentos.id')
        //     ->get();

        return response()->json([
            'dataDB' => $documentos,
            'success' => true
        ]);
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
