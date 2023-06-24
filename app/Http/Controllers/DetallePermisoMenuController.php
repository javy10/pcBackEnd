<?php

namespace App\Http\Controllers;

use App\Models\DetallePermisoMenu;
use App\Models\PermisoMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallePermisoMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // return $request->id;
        // die;

        // $detallePermiso = DetallePermisoMenu::where('habilitado', 'S')
        //                 ->where('detalle_permiso_menus.colaborador_id', '=', $request->id)
        //                 ->orwhere('detalle_permiso_menus.departamento_id', '=', $request->idDepart)
        //                 ->get();
        // return $detallePermiso;

        $detallePermiso = DB::table('detalle_permiso_menus')
            ->join('menus', 'detalle_permiso_menus.menu_id', '=', 'menus.id')
            ->leftJoin('departamentos','detalle_permiso_menus.departamento_id','=','departamentos.id')
            ->leftJoin('cargos','detalle_permiso_menus.cargo_id','=','cargos.id')
            ->join('permiso_menus','detalle_permiso_menus.permisoMenu_id','=','permiso_menus.id')
            ->leftJoin('users','detalle_permiso_menus.colaborador_id','=','users.id')
            ->select('detalle_permiso_menus.id as idConfig', 'detalle_permiso_menus.colaborador_id','users.nombres','users.apellidos','detalle_permiso_menus.cargo_id', 'cargos.nombre','detalle_permiso_menus.menu_id', 'menus.nombre as menu', 'detalle_permiso_menus.permisoMenu_id', 'detalle_permiso_menus.habilitado', 'detalle_permiso_menus.departamento_id', 'detalle_permiso_menus.created_at as fechaRegistro')
            ->where('detalle_permiso_menus.habilitado','=','S')
            ->where('detalle_permiso_menus.colaborador_id', '=', $request->id)
            ->orwhere('detalle_permiso_menus.departamento_id', '=', $request->idDepart)
            // ->where('detalle_permiso_menus.menu_id', '=', $request->menu_id)
            ->get();
        return $detallePermiso;

    }

    public function detallePermisosMenuConfiguracion(Request $request)
    {

        $detallePermiso = DB::table('detalle_permiso_menus')
            ->join('menus', 'detalle_permiso_menus.menu_id', '=', 'menus.id')
            ->leftJoin('departamentos','detalle_permiso_menus.departamento_id','=','departamentos.id')
            ->leftJoin('cargos','detalle_permiso_menus.cargo_id','=','cargos.id')
            ->join('permiso_menus','detalle_permiso_menus.permisoMenu_id','=','permiso_menus.id')
            ->leftJoin('users','detalle_permiso_menus.colaborador_id','=','users.id')
            ->select('detalle_permiso_menus.id as idConfig', 'detalle_permiso_menus.colaborador_id','users.nombres','users.apellidos','detalle_permiso_menus.cargo_id', 'cargos.nombre','detalle_permiso_menus.menu_id', 'menus.nombre as menu', 'detalle_permiso_menus.permisoMenu_id', 'detalle_permiso_menus.habilitado', 'detalle_permiso_menus.departamento_id', 'detalle_permiso_menus.created_at as fechaRegistro')
            ->where('detalle_permiso_menus.habilitado','=','S')
            ->where('detalle_permiso_menus.colaborador_id', '=', $request->id)
            ->orwhere('detalle_permiso_menus.departamento_id', '=', $request->idDepart)
            ->where('detalle_permiso_menus.menu_id', '=', $request->menu_id)
            ->get();
        return $detallePermiso;

    }


    public function obtenerDetalle()
    {

        $detallePermiso = DB::table('detalle_permiso_menus')
            ->join('menus', 'detalle_permiso_menus.menu_id', '=', 'menus.id')
            ->leftJoin('departamentos','detalle_permiso_menus.departamento_id','=','departamentos.id')
            ->leftJoin('cargos','detalle_permiso_menus.cargo_id','=','cargos.id')
            ->join('permiso_menus','detalle_permiso_menus.permisoMenu_id','=','permiso_menus.id')
            ->leftJoin('users','detalle_permiso_menus.colaborador_id','=','users.id')
            ->select('detalle_permiso_menus.id as idConfig', 'detalle_permiso_menus.colaborador_id','users.nombres','users.apellidos','detalle_permiso_menus.cargo_id', 'cargos.nombre','detalle_permiso_menus.menu_id', 'menus.nombre as menu', 'detalle_permiso_menus.permisoMenu_id', 'detalle_permiso_menus.habilitado', 'detalle_permiso_menus.departamento_id', 'detalle_permiso_menus.created_at as fechaRegistro')
            ->where('detalle_permiso_menus.habilitado','=','S')
            ->get();
        return $detallePermiso;

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

        // $permisoMenu = new PermisoMenu();
        // $permisoMenu->tipoPermisoMenu_id = $request->tipoPermisoMenu_id;
        // $permisoMenu->habilitado = 'S';
        // $permisoMenu->save();
        

        // $detallePermisoMenu = new DetallePermisoMenu();
        // $detallePermisoMenu->permisoMenu_id = $permisoMenu->id;
        // $detallePermisoMenu->menu_id = $request->menu_id;
        // $detallePermisoMenu->departamento_id = $request->departamento_id == 0 ? null : $request->departamento_id;
        // $detallePermisoMenu->cargo_id = $request->cargo_id == 0 ? null : $request->cargo_id;
        // $detallePermisoMenu->colaborador_id = $request->colaborador_id == 0 ? null : $request->colaborador_id;
        // $detallePermisoMenu->habilitado = 'S';
        // $detallePermisoMenu->save();

        // return response()->json([
            
        //     'permisoMenu' => $permisoMenu,
        //     'detallePermiso' => $detallePermisoMenu,
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
    public function show($id)
    {
        $menu = DetallePermisoMenu::select('menu_id')
                                ->where('colaborador_id', '=', $id)
                                ->where('habilitado', '=', 'S')
                                ->get();
        return response()->json([
            
            'dataDB' => $menu,
            'success' => true
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        // Paso 1: Obtener los nuevos usuarios_id
        $nuevosMenusId = $request->input('menu_id');
        //$nuevosMenusId = $myArray;
        $cadenas = $nuevosMenusId;
        $array = explode(',', $cadenas);
        $numeros = array_map('intval', $array);

        // Paso 2: Recuperar los registros existentes
        $registrosExistente = DetallePermisoMenu::where('colaborador_id', $request->id)->get();
     
        // Paso 3: Comparar los usuarios_id existentes con los nuevos usuarios_id
        $menusIdExistente = $registrosExistente->pluck('menu_id')->toArray();
        $menusIdEliminar = array_diff($menusIdExistente, $numeros);
        $menusIdAgregar = array_diff($numeros, $menusIdExistente);

        //Paso 4: Eliminar los registros que no están en los nuevos usuarios_id
        DetallePermisoMenu::where('colaborador_id', $request->id)
                        ->whereIn('menu_id', $menusIdEliminar)
                        ->delete();

        // Paso 5: Agregar los nuevos registros para los usuarios_id que no están en los registros existentes
        foreach ($menusIdAgregar as $menusId) {
            $detallePermisoMenu = new DetallePermisoMenu();
            $detallePermisoMenu->permisoMenu_id = $registrosExistente[0]->permisoMenu_id;
            $detallePermisoMenu->menu_id = $menusId;
            $detallePermisoMenu->departamento_id = $request->departamento_id == 0 ? null : $request->departamento_id;
            $detallePermisoMenu->cargo_id = $request->cargo_id == 0 ? null : $request->cargo_id;
            $detallePermisoMenu->colaborador_id = $request->id;
            $detallePermisoMenu->habilitado = 'S';
            $detallePermisoMenu->save();
        }
        
        return response()->json([
            'success' => true
        ], 200);
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


        $permisoMenu = PermisoMenu::find($request->permisoMenu_id);
        $permisoMenu->update([
            'tipoPermisoMenu_id' => $request->tipoPermisoMenu_id,
            'habilitado' => 'S',
        ]);

        $detallePermisoMenu = DetallePermisoMenu::find($request->idconfig);
        $detallePermisoMenu->update([
            'permisoMenu_id' => $request->permisoMenu_id,
            'menu_id' => $request->menu_id,
            'departamento_id' => $request->departamento_id == 0 ? null : $request->departamento_id,
            'cargo_id' => $request->cargo_id == 0 ? null : $request->cargo_id,
            'colaborador_id' => $request->colaborador_id == 0 ? null : $request->colaborador_id,
            'habilitado' => 'S',
        ]);

        return response()->json([
            'permisoMenu' => $permisoMenu,
            'detallePermiso' => $detallePermisoMenu,
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
        //
    }
}
