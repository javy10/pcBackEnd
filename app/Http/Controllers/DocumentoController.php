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

        // return $request->colaborador_id;
        // die;

        // $arr1 = json_decode(( $request->tipoPermiso_id ));
        // $arr2 = json_decode(( $request->departamento_id ));
        // $arr3 = json_decode(( $request->colaborador_id ));
        //$detalle = json_decode(( $request->detalleDoc ));


        //echo $path;
        ////// insertando datos
        $documento = new Documento();
        $documento->titulo = $request->titulo;
        $documento->descripcion = $request->descripcionDoc;
        $documento->habilitado = 'S';
        $documento->colaborador_id = $request->usuario_id;
        $documento->tipoDocumento_id = $request->tipoDocumento_id;
        $documento->save();

        $permiso = new Permiso();
        $permiso->tipoPermiso_id = $request->tipoPermiso_id;
        $permiso->habilitado = 'S';
        $permiso->save();

        $myArray = json_decode($request->colaborador_id);
            
        foreach ($myArray as $item) {
            $detallePermiso = new DetallePermiso();
            $detallePermiso->colaborador_id = $item;
            $detallePermiso->departamento_id =  null;
            $detallePermiso->documento_id = $documento->id;
            $detallePermiso->permiso_id = $permiso->id;
            $detallePermiso->habilitado = 'S';
            $detallePermiso->save();
        }


        return response()->json([
            'success' => true
        ], 201);

    }

    public function crearPermiso(Request $request) 
    {
        $permiso = new Permiso();
        $permiso->tipoPermiso_id = $request->tipoPermiso_id;
        $permiso->habilitado = 'S';
        $permiso->save();

        $detallePermiso = new DetallePermiso();
        $detallePermiso->documento_id = $request->documento_id;
        $detallePermiso->departamento_id = $request->departamento_id == 0 ? null : $request->departamento_id;
        $detallePermiso->colaborador_id = $request->colaborador_id == 0 ? null : $request->colaborador_id;
        $detallePermiso->permiso_id = $permiso->id;
        $detallePermiso->habilitado = 'S';
        $detallePermiso->save();

        return response()->json([
            'success' => true
        ], 201);


        // return $request;
        // die;

        // $detallePermiso = new DetallePermiso();
        // $detallePermiso->documento_id = $request->documento_id;
        // $detallePermiso->departamento_id = $request->departamento_id == 0 ? null : $request->departamento_id;
        // $detallePermiso->colaborador_id = $request->colaborador_id == 0 ? null : $request->colaborador_id;
        // $detallePermiso->permiso_id = $request->permiso_id;
        // $detallePermiso->habilitado = 'S';
        // $detallePermiso->save();

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
        
        // $documentos = DB::table('documentos')
        //     ->join('tipo_documentos','documentos.tipoDocumento_id','=','tipo_documentos.id')
        //     ->select('documentos.id','documentos.titulo','tipo_documentos.tipo','documentos.tipoDocumento_id','documentos.created_at')
        //     ->where('documentos.habilitado','=','S')
        //     ->get();
        // return response()->json([
        //     'dataDB' => $documentos,
        //     'success' => true
        // ]);

        $documentos = DB::table('documentos')
                        ->join('detalle_archivo_documentos', 'detalle_archivo_documentos.documento_id', '=', 'documentos.id')
                        ->join('detalle_permisos', 'detalle_permisos.documento_id', '=', 'documentos.id')
                        ->join('permisos', 'detalle_permisos.permiso_id', '=', 'permisos.id')
                        ->join('tipo_documentos', 'documentos.tipoDocumento_id', '=', 'tipo_documentos.id')
                        ->distinct()
                        ->select('documentos.id', 'documentos.titulo', 'tipo_documentos.tipo', 'documentos.tipoDocumento_id', 'documentos.created_at')
                        ->where('detalle_archivo_documentos.disponible', '=', 'S')
                        ->where('detalle_archivo_documentos.lectura', '=', 'S')
                        ->where('detalle_archivo_documentos.habilitado', '=', 'S')
                        ->get();
        return response()->json([
            'dataDB' => $documentos,
            'success' => true
        ]);
    }

    public function buscarID(Request $request)
    {

        // return $request->id;
        // die;

        //print_r($request->id);
        //die;
        // $documento = Documento::find($request->id)->where('habilitado','=', 'S');
        $documento = Documento::where('id', $request->id)->where('habilitado', 'S')->get();
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
    public function update(Request $request)
    {

        // return $request;
        // die;

        if($request->documento_id) {
            $documento = Documento::find($request->documento_id);
            $documento->update([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'tipoDocumento_id' => $request->tipoDocumento_id,
                'updated_at' => $request->updated_at,
                // 'habilitado' => 'S',
            ]);

        } else {
            
        }
        return response()->json([
            'success' => true
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $detallePermiso = new DetallePermiso();
        //         $detallePermiso->documento_id = $documento->id;
        //         $detallePermiso->departamento_id = $data == 0 ? null : $data;
        //         $detallePermiso->permiso_id = $permiso->id;
        //         $detallePermiso->habilitado = 'S';
        //         $detallePermiso->save();
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
