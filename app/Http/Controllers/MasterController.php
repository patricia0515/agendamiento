<?php

namespace App\Http\Controllers;

use App\Master;
use App\Master_historico;
use App\Tipo_identificacion;
use App\Municipios;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportesExport;
use Carbon\Carbon;

class MasterController extends Controller
{
    //
    public function consulta (Request $request){

        ////Valido rutas del explorador
        /* if (!$request->ajax()) { return redirect('/'); } */
        //Realiza la consulta
        $persona = Master::join('municipios','master.ciudad_persona','=','municipios.id')
                           ->join('tipo_identificacion','master.tipo_doc_persona','=','tipo_identificacion.idtipo_identificacion')
                           ->select(
                               'master.*',
                               'municipios.nombre_municipio as municipio',
                               'tipo_identificacion.detalle as tip_doc'
                           )
                           ->where('num_doc_persona', $request->valor)
                           ->get();
            $municipios = Municipios::select ('id','nombre_municipio')
                           ->get();
           
            $tipo_doc = Tipo_identificacion::select('idtipo_identificacion','detalle')
                                           ->where ('estado','=','1')
                                           ->get();

                        if((count($persona))==0){
                            return response()->json([$municipios, $tipo_doc],210);
                        }
        
  
        return [$persona, $municipios, $tipo_doc];

    }

    public function actualizar (Request $request)
    { 
        DB::beginTransaction();
        
        try {
           
            if($request->idmaster==0){
                //Si no existe instanciamos un nuevo objeto
                $clienteMaster =  new Master;
            }else{
                
                $clienteMaster = Master::find($request->idmaster);
            }
                
            
            $clienteMaster->num_doc_persona            = $request->num_doc_persona; 
            $clienteMaster->nombre_persona             = $request->nombre_persona;
            $clienteMaster->apellido_persona           = $request->apellido_persona;
            $clienteMaster->tipo_doc_persona           = $request->tipo_doc_persona;
            $clienteMaster->correo_persona             = $request->correo_persona;
            $clienteMaster->ciudad_persona             = $request->ciudad_persona;
            $clienteMaster->telefono1_persona          = $request->telefono1_persona;
            $clienteMaster->telefono2_persona          = $request->telefono2_persona;
            $clienteMaster->direcc_residencia_persona  = $request->direcc_residencia_persona;
            $clienteMaster->barrio_persona             = $request->barrio_persona;
            $clienteMaster->tipificacion               = $request->tipificacion;
            $clienteMaster->fecha_agendamiento         = $request->fecha_agendamiento;
            $clienteMaster->hora_agendamiento          = $request->hora_agendamiento;
            /* $clienteMaster->user_id                 = auth()->user()->id; //1 para pruebas */
            $clienteMaster->observ_persona             = $request->observ_persona;
            $clienteMaster->save();
            

            $historico                             =  new Master_historico;
            $historico->num_doc_persona            = $request->num_doc_persona; 
            $historico->nombre_persona             = $request->nombre_persona;
            $historico->apellido_persona           = $request->apellido_persona;
            $historico->tipo_doc_persona           = $request->tipo_doc_persona;
            $historico->correo_persona             = $request->correo_persona;
            $historico->ciudad_persona             = $request->ciudad_persona;
            $historico->telefono1_persona          = $request->telefono1_persona;
            $historico->telefono2_persona          = $request->telefono2_persona;
            $historico->direcc_residencia_persona  = $request->direcc_residencia_persona;
            $historico->barrio_persona             = $request->barrio_persona;
            $historico->tipificacion               = $request->tipificacion;
            $historico->fecha_agendamiento         = $request->fecha_agendamiento;
            $historico->hora_agendamiento          = $request->hora_agendamiento;
            /* $clienteMaster->user_id             = auth()->user()->id; //1 para pruebas */
            $historico->observ_persona             = $request->observ_persona;
            $historico->save();

            DB::commit();

        }catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

           

    }

    public function gestiones(){
        
        $gestiones = Master_historico::join('tipificacion','master_historico.tipificacion','=','tipificacion.idtipificacion')
        ->select(
             DB::raw("CONCAT(master_historico.nombre_persona,' ',master_historico.apellido_persona) as full_name"),
            'master_historico.idmaster_historico as id',
            'master_historico.num_doc_persona as documento',
            'master_historico.tipificacion as tipificacion',
            'tipificacion.detalle as tip',
            'master_historico.telefono1_persona as telefono',
             DB::raw('DATE(master_historico.created_at) as fecha_gestionado'),    
        )
        ->orderBy("id", "desc")
        ->get();
        
        //Declaro fechas (Hoy, Lunes y domingo de la semana actual)
        $hoy = Carbon::now();
        $lunes = $hoy->startOfWeek()->format('Y-m-d');
        $domingo = $hoy->endOfWeek()->format('Y-m-d');
        
        //Cuento gestiones durante la semana en curso donde lunes el es inicio y domingo el final
        $gestiones_semana = Master_historico::whereBetween('created_at', [$lunes.' 00:00:00', $domingo.' 23:59:59']);
        //Cuento las gestiones correspondientes a Agendamiento de Citas en la semana actual.
        $agendamiento_semanal=$gestiones_semana->where('tipificacion','=',1)->count();

        //Cuento gestiones durante el día en curso.
        $gestiones_dia = Master_historico::whereBetween('created_at', [$hoy.' 00:00:00', $hoy.' 23:59:59']);
        //Cuento las gestiones correspondientes a Agendamiento de Citas en el día actual.
        $agendamiento_diario=$gestiones_dia->where('tipificacion','=',1)->count();
        $lunes = $hoy->startOfWeek()->format('d-m-Y');
        $domingo = $hoy->endOfWeek()->format('d-m-Y');
        return [$gestiones,$agendamiento_semanal,$agendamiento_diario,$lunes,$domingo];

    }

    /**
     * Metodo que realiza la exportacion
     * de los datos a un archivo excel
     * 
     * @return ReportesExport
     */
    public function exportExcel(Request $request)
    {
        $filtro = $request->valor;
        $masterHistorico = Master_historico::join('tipificacion','master_historico.tipificacion','=','tipificacion.idtipificacion')
        ->select(
             DB::raw("CONCAT(master_historico.nombre_persona,' ',master_historico.apellido_persona) as full_name"),
            'master_historico.idmaster_historico as id',
            'master_historico.num_doc_persona as documento',
            'tipificacion.detalle as tip',
            'master_historico.telefono1_persona as telefono',
            'created_at',    
        )
        ->whereBetween('created_at', [$filtro[0].' 00:00:00', $filtro[1].' 23:59:59'])
        ->get();

        return $masterHistorico;
    }
}
