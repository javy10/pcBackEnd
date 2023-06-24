<?php

use App\Http\Controllers\agenciaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\cargoController;
use App\Http\Controllers\colaboradorController;
use App\Http\Controllers\departamentoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\DetalleArchivoDocumentoController;
use App\Http\Controllers\DetalleEvaluacionPreguntaController;
use App\Http\Controllers\DetalleGrupoEvaluacionController;
use App\Http\Controllers\DetallePermisoController;
use App\Http\Controllers\DetallePermisoMenuController;
use App\Http\Controllers\DetallePreguntaRespuestaController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\LogsEntradaSalidaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\TipoPreguntaController;
use App\Models\DetallePermiso;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth::routes();

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('register', AuthController::class, 'register');
Route::controller(AuthController::class)->group(function() {
    Route::post('register','register')->name('register');
    Route::post('login','login')->name('login');
    Route::get('user','user')->name('user');
    Route::post('logout','logout')->name('logout');
    // Route::post('/forgot-password','sendResetLinkEmail')->name('sendResetLinkEmail');
    
});
//Route::post('reset-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
//Route::post('/forgot-password','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
//$router->post('password/reset', 'ResetPasswordController@reset');

// Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

//Route::middleware(['api'])->group(function () {
    Route::controller(colaboradorController::class)->group(function() {
        Route::get('colaboradores','index')->name('colaboradores');
        Route::get('colaboradoresDeshabilitados','Deshabilitados')->name('colaboradoresDeshabilitados');
        Route::post('colaborador','createColaborador')->name('createcolaborador');
        Route::get('eliminarcolaborador/{id}','edit')->name('eliminarcolaborador');
        Route::get('desbloquear/{id}','desbloquear')->name('desbloquear');
        Route::get('colaborador/{id}','show')->name('buscarcolaboradorId');
        Route::get('obtenerColaboradorID/{id}','obtenerColaboradorID')->name('obtenerColaboradorID');
        Route::post('editarcolaborador','update')->name('editarColaborador');
        Route::get('login/{dui}','buscar')->name('buscarColaboradorDui');
        Route::get('editarintentos/{dui}','editarIntentos')->name('editarintentos');
        Route::get('editarIntentosEquivocados/{dui}','editarIntentosEquivocados')->name('editarintentos');
        Route::post('editPassword','editPassword')->name('editPassword');
        Route::get('fotoURL/{nombre}', 'obtenerFoto')->name('fotoUrl');
        //Route::post('login','singIn')->name('login');
        Route::post('recover-password','recover')->name('recover-password');
        Route::get('obtenerUsersPorEmail/{email}','obtenerUsersPorEmail')->name('obtenerUsersPorEmail');
        Route::post('buscarPorClave','buscarPorClave')->name('buscarPorClave');
    });
//});

Route::controller(agenciaController::class)->group(function() {
    Route::get('agencias','index')->name('agencias');
    Route::get('agencia/{id}','show')->name('buscaragenciaId');
});

Route::controller(departamentoController::class)->group(function() {
    Route::get('departamentos','index')->name('departamentos');
    Route::get('departamento/{id}','show')->name('buscardepartamentoId');
});

Route::controller(cargoController::class)->group(function() {
    Route::get('cargos','index')->name('cargos');
    Route::get('cargos/{id}','show')->name('cargosId');
    Route::get('cargo/{id}','buscar')->name('cargoId');
    Route::post('guardarCargo','create')->name('guardarCargo');
});

Route::controller(TipoDocumentoController::class)->group(function() {
    Route::post('tipoDocumento','create')->name('tipoDocumento');
    Route::get('tipoDocumentos','index')->name('tipoDocumentos');
    Route::post('buscarTipoDocumentos','buscarTipo')->name('tipoDocumentos');
    Route::get('tiposDocumentos','tipoDocumentos')->name('tipoDocumentos');
    Route::get('tipoDocumentos/{id}','show')->name('buscartipoDocumentosId');
    Route::get('eliminarTipoDocumento/{id}','edit')->name('eliminartipoDocumentosId');
    Route::get('desbloquear/{id}','desbloquear')->name('desbloquear');
    Route::post('editar','update')->name('editar');
});

Route::controller(DocumentoController::class)->group(function() {
    Route::post('documentos', 'create')->name('documentos');
    Route::get('listaDocumentos', 'show')->name('documentos');
    Route::get('eliminardocumentos/{id}', 'edit')->name('documentos');
    Route::get('documentos/{nombre}', 'index')->name('documentos');
    Route::get('documentoID/{id}', 'buscarID')->name('documentos');
    Route::post('editarDocumento','update')->name('editarDocumento');
    Route::post('guardarPermiso','crearPermiso')->name('crearPermiso');
    
});

Route::controller(DetalleArchivoDocumentoController::class)->group(function() {
    Route::get('documentos', 'show')->name('documentos');
    Route::post('documentosList', 'obtenerDocumentosID')->name('obtenerDocumentosID');
    Route::get('detalleDoc/{id}', 'index')->name('detalleDoc');
    Route::get('detalleDocumento/{id}', 'buscarDetalle')->name('detalleDocumento');
    Route::post('guardarDetalle', 'create')->name('guardarDetalle');
    Route::post('editarDetalleDocumento','update')->name('editarDetalleDocumento');
    Route::get('eliminarDetalledocumentos/{id}', 'edit')->name('eliminarDetalledocumentos');
    Route::get('documentoDeshabilitadosID/{id}', 'buscarDocDeshabilitados')->name('documentoDeshabilitadosID');
});

Route::controller(DetallePermisoController::class)->group(function() {
    Route::get('permisos', 'index')->name('permisos');
    Route::get('obtenerDetallePermiso', 'obtenerDetallePermiso')->name('obtenerDetallePermiso');
    Route::get('detallePermisos/{id}', 'show')->name('permisos');
    Route::get('detalleDocPermisos/{id}', 'obtenerDetallePermisoID')->name('detalleDocPermisos');
    Route::get('detalleID/{id}', 'detalleID')->name('detallePer');
    Route::post('editarDetallePermiso','update')->name('editarDetallePermiso');
    Route::get('eliminarDetallePermiso/{id}','edit')->name('eliminarDetallePermiso');
    Route::get('buscarColaboradoresPermisos/{id}','store')->name('buscarColaboradoresPermisos');
});

Route::controller(PermisoController::class)->group(function() {
    Route::post('editarPermiso','update')->name('editarPermiso');
});

Route::controller(MenuController::class)->group(function() {
    Route::get('menus','index')->name('menus');
});

Route::controller(DetallePermisoMenuController::class)->group(function() {
    Route::get('obtenerDetalle', 'obtenerDetalle')->name('obtenerDetalle');
    Route::post('detallePermisosMenu','index')->name('detalles');
    Route::post('detallePermisosMenuConfiguracion','detallePermisosMenuConfiguracion')->name('detallePermisosMenuConfiguracion');
    Route::post('configuracion', 'create')->name('configuracion');
    Route::post('editarconfiguracion','update')->name('editarconfiguracion');
    Route::get('detallePermisosMenu/{id}', 'show')->name('detallePermisosMenu');
    Route::post('editarDetallePermisosMenu','edit')->name('editarDetallePermisosMenu');
});

Route::controller(LogsEntradaSalidaController::class)->group(function() {
    Route::post('editarSalida','editarSalida')->name('editarSalida');
    Route::post('editarEntrada','editarEntrada')->name('editarEntrada');
});

Route::controller(GrupoController::class)->group(function() {
    Route::post('crearGrupo','create')->name('create');
    Route::get('obtenerGrupoID/{id}','show')->name('obtenerGrupoID');
    Route::get('obtenerColaboradoresGrupoID/{id}','store')->name('obtenerColaboradoresGrupoID');
    Route::post('editarGrupo','update')->name('editarGrupo');
    Route::get('eliminarGrupo/{id}','edit')->name('eliminarGrupo');
});

Route::controller(EvaluacionController::class)->group(function() {
    Route::post('crearEvaluacion','create')->name('create');
    Route::get('obtenerEvaluaciones','index')->name('obtenerEvaluaciones');
    Route::get('obtenerEvaluacionesDeshabilitadas','obtenerEvaluacionesDeshabilitadas')->name('obtenerEvaluacionesDeshabilitadas');
    Route::get('obtenerEvaluacionID/{id}','show')->name('obtenerEvaluacionID');
    Route::post('editarCantidadPreguntas','edit')->name('editarCantidadPreguntas');
    Route::post('editarEvaluacion','update')->name('editarEvaluacion');
    Route::get('eliminarEvaluacion/{id}', 'deshabilitarEvaluacion')->name('eliminarEvaluacion');
    Route::post('editarIntentosEvaluacion', 'editarIntentosEvaluacion')->name('editarIntentosEvaluacion');
});

Route::controller(DetalleGrupoEvaluacionController::class)->group(function() {
    Route::post('crearDetalleGrupo','create')->name('create');
    Route::post('editarEvalaucionDetalleGrupo','edit')->name('edit');
    Route::get('obtenerGrupo','index')->name('obtenerGrupo');
    Route::post('editarDetalleGrupo','update')->name('editarDetalleGrupo');
    Route::get('habilitarEvaluacion/{id}','habilitarEvaluacion')->name('habilitarEvaluacion');
    Route::get('obtenerDetalleGrupoEvaluacion/{id}','show')->name('obtenerDetalleGrupoEvaluacion');
    Route::get('intentosColaboradores','intentosColaboradores')->name('intentosColaboradores');
    Route::get('habilitarIntentosEvaluacion/{id}','habilitarIntentosEvaluacion')->name('habilitarIntentosEvaluacion');
    Route::post('obtenerResultadosEvaluacion', 'obtenerResultadosEvaluacion')->name('obtenerResultadosEvaluacion');
});

Route::controller(TipoPreguntaController::class)->group(function() {
    Route::get('obtenerTipoPregunta','index')->name('obtenerTipoPregunta');
    
});

Route::controller(PreguntaController::class)->group(function() {
    Route::post('crearPreguntas','create')->name('crearPreguntas');
    
});

Route::controller(RespuestaController::class)->group(function() {
    Route::post('crearRespuestas','create')->name('crearRespuestas');
    
});

Route::controller(DetalleEvaluacionPreguntaController::class)->group(function() {
    Route::get('conteoPreguntas/{id}','show')->name('conteoPreguntas');
    Route::post('obtenerPreguntasQuiz','index')->name('obtenerPreguntasQuiz');
    Route::get('obtenerPreguntasRespuestas/{id}','store')->name('obtenerPreguntasRespuestas');
    
});

Route::controller(DetallePreguntaRespuestaController::class)->group(function() {
    Route::get('obtenerRespestasQuiz/{id}','index')->name('obtenerRespestasQuiz');
    Route::post('obtenerRespuestaCorrecta','show')->name('obtenerRespuestaCorrecta');
});

Route::controller(ResultadoController::class)->group(function() {
    Route::post('guardarResultadoPreguntas','create')->name('guardarResultadoPreguntas');
    
});
