<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menus = Menu::all()->where('habilitado', '=', 'S');
        return response()->json([
            'dataDB' => $menus,
            'success' => true
        ]);

        // $menus = DB::table('menus')
        //     ->join('detalle_permisos_menus','detalle_permisos_menus.menu_id','=','menus.id')
        //     ->select('menus.nombre', 'menus.id')
        //     ->where('menus.habilitado','=','S')
        //     ->Where('detalle_permisos_menus.colaborador_id','=', $request->idColaborador)
        //     ->orWhere('detalle_permisos_menus.cargo_id','=', $request->idCargo)
        //     ->get();
        // return response()->json([
        //     'dataDB' => $menus,
        //     'success' => true
        // ]);
        
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
