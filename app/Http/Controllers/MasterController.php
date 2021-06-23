<?php

namespace App\Http\Controllers;

use App\Master;
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
        $persona = Master::where('num_doc_persona', '=', $request->valor)
                        ->get();

        if((count($persona))==0){
            return response()->json(['errors'=>['mensaje'=>'No se encuentra cliente.']], 210); 
        }
        /* dd($persona); */
        return $persona;

    }

    /**
     * Metodo que realiza la exportacion
     * de los datos a un archivo excel
     * 
     * @return ReportesExport
     */
    public function exportExcel(Request $request)
    {
        
        // $filtro1 = $request->valor[0];
        // $filtro2 = $request->valor[1];
        // return (new ReportesExport($filtro1, $filtro2))->download('reportExcel.xlsx');
        // $msne = "Hola desde el controlador.";
        // return response()->json($msne);
        return Excel::download(new ReportesExport, 'Master.xlsx');
    }
}
