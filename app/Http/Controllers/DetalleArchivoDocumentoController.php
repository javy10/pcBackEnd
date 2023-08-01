<?php

namespace App\Http\Controllers;

use App\Models\DetalleArchivoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Documento;

class DetalleArchivoDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // $detalleDoc = DetalleArchivoDocumento::find($request->id);
        // return response()->json([
        //     'dataDB' => $detalleDoc,
        //     'success' => true
        // ]);

        $detalleDoc = DetalleArchivoDocumento::where('documento_id', $request->id)->where('habilitado', 'S')->get();
        return response()->json([
            'dataDB' => $detalleDoc,
            'success' => true
        ]);
        
    }

    public function buscarDetalle(Request $request)
    {

        $detalleDoc = DetalleArchivoDocumento::where('id', $request->id)->get();
        return response()->json([
            'dataDB' => $detalleDoc,
            'success' => true
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $file = $request->file('url');
        $fileName = $file->getClientOriginalName();
        // $filePath = public_path($request->titulo);
        // $path = $file->storeAs('public/pdf', $request->titulo);
        $filePath = public_path($fileName);
        $path = $file->storeAs('public/pdf', $fileName);

        //$documento = new Documento();
        $ultimoId = Documento::latest()->first()->id;

        $detalleDoc = new DetalleArchivoDocumento();
        $detalleDoc->documento_id = $ultimoId;
        $detalleDoc->descripcion = $request->descripcionDetalle;
        $detalleDoc->lectura = $request->lectura;
        $detalleDoc->fechaLimite = $request->fechaLimite == '' ? null : $request->fechaLimite;
        $detalleDoc->habilitado = 'S';
        $detalleDoc->nombreArchivo = $fileName;
        //$detalleDoc->urlArchivo = $filePath;
        $detalleDoc->disponible = $request->disponible;
        $detalleDoc->save();

        return response()->json([
            'success' => true
        ], 201);

        // ******************************************************************************************* //

        // $file = $request->file('url');
        // $fileName = $file->getClientOriginalName();
        // // $filePath = public_path($request->titulo);
        // // $path = $file->storeAs('public/pdf', $request->titulo);
        // $filePath = public_path($fileName);
        // $path = $file->storeAs('public/pdf', $fileName);

        //$documento = new Documento();
        // $ultimoId = Documento::latest()->first()->id;

        // $detalleDoc = new DetalleArchivoDocumento();
        // $detalleDoc->documento_id = $request->documento_id;
        // $detalleDoc->descripcion = $request->descripcionDetalle;
        // $detalleDoc->lectura = $request->lectura;
        // $detalleDoc->fechaLimite = $request->fechaLimite == '' || $request->fechaLimite == null ? null : $request->fechaLimite;
        // $detalleDoc->habilitado = 'S';
        // $detalleDoc->nombreArchivo = $request->nombreArchivo;
        // $detalleDoc->disponible = $request->disponible;
        // $detalleDoc->save();

        // return response()->json([
        //     'success' => true
        // ], 201);

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
        // return $request;
        // die;
        $documentos = DB::table('documentos')
            ->join('detalle_archivo_documentos', 'detalle_archivo_documentos.documento_id', '=', 'documentos.id')
            ->join('detalle_permisos', 'detalle_permisos.documento_id','=','documentos.id')
            ->join('permisos','detalle_permisos.permiso_id','=','permisos.id')
            ->join('tipo_documentos','documentos.tipoDocumento_id','=','tipo_documentos.id')
            ->distinct()->select('documentos.tipoDocumento_id', 'tipo_documentos.tipo', 'detalle_archivo_documentos.nombreArchivo', 'permisos.tipoPermiso_id', 'detalle_permisos.documento_id', 'detalle_permisos.departamento_id', 'detalle_permisos.colaborador_id', 'detalle_archivo_documentos.fechaLimite', 'detalle_archivo_documentos.disponible', 'detalle_archivo_documentos.lectura')
            ->where('documentos.habilitado','=','S')
            ->get();
        return response()->json([
            'dataDB' => $documentos,
            'success' => true
        ]);

        // $documentos = DB::table('documentos')
        //     ->join('detalle_archivo_documentos', 'detalle_archivo_documentos.documento_id', '=', 'documentos.id')
        //     ->join('detalle_permisos', 'detalle_permisos.documento_id','=','documentos.id')
        //     ->join('permisos','detalle_permisos.permiso_id','=','permisos.id')
        //     ->join('tipo_documentos','documentos.tipoDocumento_id','=','tipo_documentos.id')
        //     ->distinct()->select('detalle_archivo_documentos.nombreArchivo',  'detalle_archivo_documentos.fechaLimite', 'detalle_archivo_documentos.disponible', 'detalle_archivo_documentos.lectura', 'documentos.tipoDocumento_id', 'tipo_documentos.tipo', 'detalle_permisos.documento_id')
        //     ->where(function ($query) use ($request) {
        //         $query->where('(detalle_permisos.colaborador_id', '=', $request->idC)
        //               ->orWhere('detalle_permisos.departamento_id', '=', $request->idD);
        //     })
        //     ->where('detalle_archivo_documentos.disponible','=','0')
        //     ->where('detalle_archivo_documentos.lectura','=','0')
        //     ->where('detalle_archivo_documentos.habilitado','=','S')
        //     ->get();
        // return response()->json([
        //     'dataDB' => $documentos,
        //     'success' => true
        // ]);
    }



    
    // ->where(function ($query) use ($request) {
    //     $query->where('(detalle_permisos.colaborador_id', '=', $request->idC)
    //           ->orWhere('detalle_permisos.departamento_id', '=', $request->idD);
    // })

    public function obtenerDocumentosID(Request $request)
    {

        $documentos = DB::table('documentos')
            ->join('detalle_archivo_documentos', 'detalle_archivo_documentos.documento_id', '=', 'documentos.id')
            ->join('detalle_permisos', 'detalle_permisos.documento_id','=','documentos.id')
            ->join('permisos','detalle_permisos.permiso_id','=','permisos.id')
            ->join('tipo_documentos','documentos.tipoDocumento_id','=','tipo_documentos.id')
            ->distinct()->select('detalle_archivo_documentos.nombreArchivo',  'detalle_archivo_documentos.fechaLimite', 'detalle_archivo_documentos.disponible', 'detalle_archivo_documentos.lectura', 'documentos.tipoDocumento_id', 'tipo_documentos.tipo', 'detalle_permisos.documento_id', 'documentos.titulo')

            ->where(function ($query) use ($request) {
                $query->where('detalle_permisos.colaborador_id', '=', $request->idC)
                      ->orWhereIn('detalle_permisos.departamento_id', $request->idD)
                      ->orWhereIn('detalle_permisos.cargo_id', $request->idCa);
            })

            ->where('detalle_archivo_documentos.disponible','=','S')
            ->where('detalle_archivo_documentos.lectura','=','S')
            ->where('detalle_archivo_documentos.habilitado','=','S')
            ->get();

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
    public function edit(Request $request)
    {
        //
        $documentos = DetalleArchivoDocumento::findOrFail($request->id)->update([
            'habilitado' => 'N'
        ]);
        return response()->json([
            'dataDB' => $documentos,
            'success' => true
        ]);
    }

    public function buscarDocDeshabilitados(Request $request)
    {
        //
        $resultados = DB::table('documentos')
                ->join('detalle_archivo_documentos', 'detalle_archivo_documentos.documento_id', '=', 'documentos.id')
                ->select('documentos.id', 'documentos.titulo', 'detalle_archivo_documentos.habilitado')
                ->where('documentos.tipoDocumento_id', '=', $request->id)
                ->where('detalle_archivo_documentos.habilitado', '=', 'N')
                ->distinct()
                ->get();

        return response()->json([
            'dataDB' => $resultados,
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

        // return $request;
        // die;
        //echo $request->url;
        if($request->id != 'undefined') {
            $file = $request->file('url');
            if($file != null || $file != '') {
                //$fileName = $file->getClientOriginalName();
                $filePath = public_path($request->titulo);
                $path = $file->storeAs('public/pdf', $request->titulo);
            }
            $detalleDoc = DetalleArchivoDocumento::find($request->id);
            $detalleDoc->update([
                'documento_id' => $request->documento_id,
                'descripcion' => $request->descripcionDetalle,
                'lectura' => $request->lectura,
                'fechaLimite' => $request->fechaLimite == '' ? null : $request->fechaLimite,
                'updated_at' => $request->updated_at,
                'habilitado' => 'S',
                'nombreArchivo' => $request->titulo,
                'disponible' => $request->disponible,
            ]);

            return response()->json([
                'dataDB' => $detalleDoc,
                'success' => true
            ]);
        }
        else 
        {
            $file = $request->file('url');
            //$fileName = $file->getClientOriginalName();
            $filePath = public_path($request->titulo);
            $path = $file->storeAs('public/pdf', $request->titulo);

            //$documento = new Documento();
            //$ultimoId = Documento::latest()->first()->id;

            $detalleDoc = new DetalleArchivoDocumento();
            $detalleDoc->documento_id = $request->documento_id;
            $detalleDoc->descripcion = $request->descripcionDetalle;
            $detalleDoc->lectura = $request->lectura;
            $detalleDoc->fechaLimite = $request->fechaLimite == '' ? null : $request->fechaLimite;
            $detalleDoc->habilitado = 'S';
            $detalleDoc->nombreArchivo = $request->titulo;
            //$detalleDoc->urlArchivo = $filePath;
            $detalleDoc->disponible = $request->disponible;
            $detalleDoc->save();

            return response()->json([
                'dataDB' => $detalleDoc,
                'success' => true
            ]);
        }
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
