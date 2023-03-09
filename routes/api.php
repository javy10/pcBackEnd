<?php

use App\Http\Controllers\agenciaController;
use App\Http\Controllers\cargoController;
use App\Http\Controllers\colaboradorController;
use App\Http\Controllers\departamentoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(colaboradorController::class)->group(function() {
    Route::get('colaborador','index')->name('colaborador');
});

Route::controller(agenciaController::class)->group(function() {
    Route::get('agencias','index')->name('agencias');
});

Route::controller(departamentoController::class)->group(function() {
    Route::get('departamentos','index')->name('departamentos');
});

Route::controller(cargoController::class)->group(function() {
    Route::get('cargos','index')->name('cargos');
    Route::get('cargos/{id}','show')->name('cargosId');
});

