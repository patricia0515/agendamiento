<?php

namespace App\Http\Controllers;

use App\Models\RolAppMaster;
use Illuminate\Http\Request;
use App\Models\UsuarioAppMaster;
use App\Models\User;
use Auth;

class AppMasterController extends Controller
{
    //
    public $idUsuario, $idCrm;

    public function appMaster(Request $request)
    {

        ////Para pruebas locales
        // return view('usuarios/asesor');
        //  return view('usuarios/administrador');


        /*inicio de activacion usuario_crm*/
        //inicio app master
        $this->idUsuario = $_GET['idusuario'];
        $this->idCrm = $_GET['crm'];

        //Agregado 
        $usuarioRol = UsuarioAppMaster::where('id_usuario', $this->idUsuario)->get();

        $roles = RolAppMaster::where('id_modulo', '=', $this->idCrm)
            ->where('id_usuario', $this->idUsuario)->get();
        //dd($roles);
        if ($usuarioRol != null) {

            //Agregado
            $idRol = $roles[0]->numero_rol;
            $consUser = User::where('id_usercrm', '=', $this->idUsuario)->first();

            if ($consUser == null) {
                //Agregado
                $consUser = new User();
                $consUser->documento = $usuarioRol[0]->cedula_usuario;
                $consUser->nombre = strtoupper($usuarioRol[0]->nombre_usuario);
                $consUser->apellido = strtoupper($usuarioRol[0]->apellido_usuario);
                $consUser->id_usercrm = $this->idUsuario;
                $consUser->rol_id = $idRol;
                $consUser->save();
            } else {
                // Agregado
                User::where('id_usercrm', '=', $this->idUsuario)
                    ->update([
                        'documento' => $usuarioRol[0]->cedula_usuario,
                        'nombre' => strtoupper($usuarioRol[0]->nombre_usuario),
                        'apellido' => strtoupper($usuarioRol[0]->apellido_usuario),
                        'rol_id' => $idRol
                    ]);
            }

            Auth::loginUsingId($consUser->id);

            if ($idRol == 0) {
                return view('reportes', compact('idRol'));
            }

            if ($idRol == 1) {
                dd($idRol);
                return view('usuarios/asesor', compact('idRol'));
            }
        } else {
            abort('403');
        }

        /*fin de activacion usuario_crm*/
    }
}
