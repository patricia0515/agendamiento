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

/* Route::get('/', function () {
    return view('welcome');
}); */

//**Validación del usuario en la base de datos crm_masterclaro */
/* Route::get('/', 'AppMasterController@appmaster');
 */
////Rutas para Usuario Asesor
Route::get('/', function () {
    $idRol = 1;
    return view('usuarios/asesor', compact('idRol'));
});
Route::post('consultaPersona', 'MasterController@consulta');
Route::post('listar-tipificaciones', 'TipificacionController@listar');
Route::post('listar-subtipificaciones', 'TipificacionController@listarSubtipificacion');
Route::post('actualizar-master', 'MasterController@actualizar');
Route::get('gestiones', 'MasterController@gestiones');

// Ruta para reportes y administrador
Route::get('/reportes', function (){
    return view('reportes');
});

/* Aqui pongo la ruta para generar el excel */
Route::post('reportExcel', 'MasterController@exportExcel');
Route::post('reportExcel2', 'MasterController@exportExcel2');