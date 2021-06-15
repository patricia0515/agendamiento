<?php

namespace App\Http\Controllers;

use App\Tipificacion;
use App\Sub_tipificacion;
use DB;
use Illuminate\Http\Request;

class TipificacionController extends Controller
{
    public function listar(Request $request)
    {
 
        $lista_items=Tipificacion::where('estado',$request->estado)
        
        ->orderBy('idtipificacion','asc')
        ->get();
        if((count($lista_items))==0){
            return response()->json(['errors'=>['mensaje'=>'No se encuentran tipificaciones.']], 210); 
        }
        
        return $lista_items;
    }
    public function listarSubtipificacion(Request $request)
    {
 
        $lista_items=Sub_tipificacion::where('idtipificacion',$request->id)
        
        ->orderBy('idsub_tipificacion','asc')
        ->get();
        if((count($lista_items))==0){
            return response()->json(['errors'=>['mensaje'=>'No se encuentran Subtipificaciones.']], 210); 
        }
        
        return $lista_items;
    }

}
