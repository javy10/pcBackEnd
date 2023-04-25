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
use App\Http\Controllers\DetallePermisoController;
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
    Route::post('/forgot-password','sendResetLinkEmail')->name('sendResetLinkEmail');
});
//Route::post('reset-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
//Route::post('/forgot-password','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
//$router->post('password/reset', 'ResetPasswordController@reset');

// Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::controller(colaboradorController::class)->group(function() {
    Route::get('colaboradores','index')->name('colaboradores');
    Route::post('colaborador','createColaborador')->name('createcolaborador');
    Route::get('eliminarcolaborador/{id}','edit')->name('eliminarcolaborador');
    Route::get('desbloquear/{id}','desbloquear')->name('desbloquear');
    Route::get('colaborador/{id}','show')->name('buscarcolaboradorId');
    Route::post('editarcolaborador','update')->name('editarColaborador');
    Route::get('login/{dui}','buscar')->name('buscarColaboradorDui');
    Route::get('editarintentos/{dui}','editarIntentos')->name('editarintentos');
    Route::get('editarIntentosEquivocados/{dui}','editarIntentosEquivocados')->name('editarintentos');
    Route::post('editPassword','editPassword')->name('editPassword');
    Route::get('fotoURL/{nombre}', 'obtenerFoto')->name('fotoUrl');
    //Route::post('login','singIn')->name('login');
});

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
});

Route::controller(TipoDocumentoController::class)->group(function() {
    Route::get('tipoDocumentos','index')->name('tipoDocumentos');
    Route::get('tipoDocumentos/{id}','show')->name('buscartipoDocumentosId');
});

Route::controller(DocumentoController::class)->group(function() {
    Route::post('documentos', 'create')->name('documentos');
    Route::get('listaDocumentos', 'show')->name('documentos');
    Route::get('eliminardocumentos/{id}', 'edit')->name('documentos');
    Route::get('eliminardocumentos/{id}', 'edit')->name('documentos');
    Route::get('documentos/{nombre}', 'index')->name('documentos');
  
});

Route::controller(DetalleArchivoDocumentoController::class)->group(function() {
    Route::get('documentos', 'show')->name('documentos');
});

Route::controller(DetallePermisoController::class)->group(function() {
    Route::get('permisos', 'index')->name('permisos');
});
