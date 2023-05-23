<?php

namespace App\Http\Controllers;

use App\Models\LogsEntradaSalida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsEntradaSalidaController extends Controller
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
    public function editarSalida(Request $request)
    {
        
        if($request->colaborador_id) {

            $user = LogsEntradaSalida::where('colaborador_id', $request->colaborador_id)->update([
                'fechaSalida' => $request->fechaSalida
            ]);
            return response()->json([
                // 'dataDB' => $documentos,
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
    public function editarEntrada(Request $request)
    {

        // return $request;
        // die;

        if($request->colaborador_id) {

            $user = LogsEntradaSalida::where('colaborador_id', $request->colaborador_id)->get();
            // return $user;
            // die;
            if($user->isNotEmpty()){

                $user = LogsEntradaSalida::where('colaborador_id', $request->colaborador_id)->update([
                    'fechaEntrada' => $request->fechaEntrada
                ]);
                
                return response()->json([
                    'success' => true
                ], 201);
            }
            else {

                $log = new LogsEntradaSalida();
                $log->colaborador_id = $request->colaborador_id;
                $log->fechaEntrada = $request->fechaEntrada;
                $log->fechaSalida = null;
                $log->habilitado = 'S';

                $log->save();

                return response()->json([
                    'success' => true
                ], 201);
            }
            
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
