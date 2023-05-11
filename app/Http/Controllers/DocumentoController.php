<?php

namespace App\Http\Controllers;

use App\Models\DetalleArchivoDocumento;
use App\Models\DetallePermiso;
use App\Models\Documento;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $file = public_path('storage\\pdf\\'.$request->nombre);
        $headers = array('Content-Type: application/pdf');
        return response()->file($file, $headers);
        // echo $ruta;
        // return response()->json([
        //     'url' => $ruta,
        //     'success' => true
        // ], 201);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // return $request;
        // die;

        $arr1 = json_decode(( $request->tipoPermiso_id ));
        $arr2 = json_decode(( $request->departamento_id ));
        $arr3 = json_decode(( $request->colaborador_id ));
        // $detalle = json_decode(( $request->detalleDoc ));

        $file = $request->file('url');
        //$fileName = $file->getClientOriginalName();
        $filePath = public_path($request->titulo);
        $path = $file->storeAs('public/pdf', $request->titulo);

        //echo $path;
        ////// insertando datos
        $documento = new Documento();
        $documento->titulo = $request->titulo;
        $documento->descripcion = $request->descripcion;
        $documento->habilitado = 'S';
        $documento->colaborador_id = $request->usuario_id;
        $documento->tipoDocumento_id = $request->tipoDocumento_id;
        $documento->save();

        $detalleDoc = new DetalleArchivoDocumento();
        $detalleDoc->documento_id = $documento->id;
        $detalleDoc->descripcion = $request->descripcionDetalle;
        $detalleDoc->lectura = $request->lectura;
        $detalleDoc->fechaLimite = $request->fechaLimite == '' ? null : $request->fechaLimite;
        $detalleDoc->habilitado = 'S';
        $detalleDoc->nombreArchivo = $request->titulo;
        //$detalleDoc->urlArchivo = $filePath;
        $detalleDoc->disponible = $request->disponible;
        $detalleDoc->save();

        foreach($arr1 as $item){
            $permiso = new Permiso();
            $permiso->tipoPermiso_id = $item;
            $permiso->habilitado = 'S';
            $permiso->save();

        }
        foreach($arr2 as $data){
            if($data != 0){
                $detallePermiso = new DetallePermiso();
                $detallePermiso->documento_id = $documento->id;
                $detallePermiso->departamento_id = $data == 0 ? null : $data;
                $detallePermiso->permiso_id = $permiso->id;
                $detallePermiso->habilitado = 'S';
                $detallePermiso->save();
            }
        }
        foreach($arr3 as $datos) {
            if($datos != 0){
                $detallePermiso = new DetallePermiso();
                $detallePermiso->documento_id = $documento->id;
                $detallePermiso->colaborador_id = $datos == 0 ? null : $datos;
                $detallePermiso->permiso_id = $permiso->id;
                $detallePermiso->habilitado = 'S';
                $detallePermiso->save();
            }
        }


        return response()->json([
            
            // 'documento' => $documento,
            // 'detalleDoc' => $detalleDoc,
            // 'permiso' => $permiso,
            // 'detallePermiso' => $detallePermiso,
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
    public function show()
    {
        $documentos = DB::table('detalle_archivo_documentos')
            ->join('documentos', 'detalle_archivo_documentos.documento_id', '=', 'documentos.id')
            ->join('tipo_documentos','documentos.tipoDocumento_id','=','tipo_documentos.id')
            ->select('documentos.id','documentos.titulo','tipo_documentos.tipo','documentos.tipoDocumento_id', 'detalle_archivo_documentos.nombreArchivo','documentos.created_at')
            ->where('documentos.habilitado','=','S')
            ->get();
        return response()->json([
            'dataDB' => $documentos,
            'success' => true
        ]);
    }

    public function buscarID(Request $request)
    {
        $documento = Documento::find($request->id);
        return response()->json([
            'dataDB' => $documento,
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
        $documentos = Documento::findOrFail($request->id)->update([
            'habilitado' => 'N'
        ]);
        return response()->json([
            'dataDB' => $documentos,
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


/** 
 * 
 *   
        // foreach($arr1 as $item){
        //     $permiso = new Permiso();
        //     $permiso->documento_id = $documento->id;
        //     $permiso->tipoPermiso_id = $item;
        //     $permiso->habilitado = 'S';
        //     $permiso->save();
        // }
        // foreach($arr2 as $data){
        //     if($data != 0){
        //         $detallePermiso = new DetallePermiso();
        //         $detallePermiso->departamento_id = $data == 0 ? null : $data;
        //         $detallePermiso->permiso_id = $permiso->id;
        //         $detallePermiso->habilitado = 'S';
        //         $detallePermiso->save();
        //     }
        // }
        // foreach($arr3 as $datos) {
        //     if($datos != 0){
        //         $detallePermiso = new DetallePermiso();
        //         $detallePermiso->colaborador_id = $datos == 0 ? null : $datos;
        //         $detallePermiso->permiso_id = $permiso->id;
        //         $detallePermiso->habilitado = 'S';
        //         $detallePermiso->save();
        //     }
        // }
 * **/
