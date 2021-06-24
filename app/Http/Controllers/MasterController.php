<?php

namespace App\Http\Controllers;

use App\Master;
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

        // dd($request->all());

        /* if(!$request->preKit && !$request->preBono && !$request->observacion){
            $msne = "No hay información para guardar, si no desea continuar haga click sobre el botón Cancelar.";
            return response()->json(['mensaje' => $msne], 210);

        } */


        DB::beginTransaction();
        
        try {

            $clienteMaster = Master::where('idmaster', '=', $request->idmaster)->first();

            if(isset($clienteMaster)){
                //recuperamos un registro de un modelo a partir de su ID sin necesidad de comprobar si existe
                //En el caso de no existir lanza una exepción NodelNotFoundException
                $master = Gestion::findOrFail($clienteMaster->idmaster);
            }else{
                //Si no existe instanciamos un nuevo objeto
                $master = new Master;
            }
               
            $master->nombre_persona          = $request->nombre_persona;
            $master->apellido_persona        = $request->apellido_persona;
            $master->tipo_doc_persona        = $request->tipo_doc_persona;
            $master->fecha_agendamiento      = $request->fecha_agendamiento;
            /* $master->user_id                 = auth()->user()->id; //1 para pruebas */
            $master->observ_persona          = $request->observ_persona;
            $master->save();

            $master_historico                     = new Master_historico;
            $master_historico->num_doc_persona    = $request->num_doc_persona;
            /* $master_historico->user_id                 = auth()->user()->id; //1 para pruebas */
            $master_historico->save();
            
            DB::commit();

        }catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
        

    }

    /**
     * Metodo que realiza la exportacion
     * de los datos a un archivo excel
     * 
     * @return ReportesExport
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new ReportesExport, 'Master.xlsx');
    }
}
