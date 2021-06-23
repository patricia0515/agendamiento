<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**Validación del usuario en la base de datos crm_masterclaro */
/* Route::get('/', 'AppMasterController@appmaster');
 */
/* Route::get('/', function () {
    $idRol = 1;
    return view('usuarios/asesor', compact('idRol'));
}); */

////Rutas para Usuario Asesor
Route::post('consultaPersona', 'MasterController@consulta');
Route::post('listar-tipificaciones', 'TipificacionController@listar');
Route::post('listar-subtipificaciones', 'TipificacionController@listarSubtipificacion');

// Ruta para reportes y administrador
Route::get('/reportes', function (){
    return view('reportes');
});

/* Aqui pongo la ruta para generar el excel */
Route::post('reportExcel', 'MasterController@exportExcel');