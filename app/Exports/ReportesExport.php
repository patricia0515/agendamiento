<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
/*  Control del ancho automatico de la columna */
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
/* Dando estilos a las celdas */
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
/* Me permite exportar la consulta en especifico */
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Carbon\Carbon;
use DB;

use App\Master;
// use Maatwebsite\Excel\Concerns\FromCollection;


class ReportesExport implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function __construct(string $filtro1, string $filtro2)
    {
        $this->fecha_inicial = $filtro1;
        $this->fecha_final = $filtro2;
    }
    


    public function query()
    
    {
        return Master::join('master', 'master_historico.idmaster_historico', '=', 'master.idmaster')
            ->select(
                'master.documento as cedula',
                'master.nombre',
                'master.apellido',
                'master_historico.created_at as entrada',
                'master_historico.reg_pertenencias as pertenencias',
                'master_historico.sede',
                'master_historico.serial',
                'master_historico.resp_visita',
                'master_historico.motivo',
                'master_historico.descripcion',
                'master_historico.visita',
                'master_historico.tip_visitante',
                'master_historico.updated_at as salida'
            )
            
            /* ->whereBetween('visitas.created_at', [$this->fecha_inicial, $this->fecha_final]) */
            ->orderBy('master_historico.idmaster_historico', 'desc');
    }


    public function headings(): array
    {
        return [
            'CEDULA',
            'NOMBRE',
            'APELLIDO',
            'FECHA DE INGRESO',
            'REGISTRO DE PERTENENCIAS',
            'AREA',
            'SERIAL',
            'RESPONSABLE DE VISITA',
            'MOTIVO DE VISITA',
            'DESCRIPCION',
            'VISITA A',
            'TIPO VISITA',
            'HORA DE SALIDA',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true], ['italic' => true]],

            // Styling a specific cell by coordinate.
            /* 'B2' => ['font' => ['italic' => true]], */

            // Styling an entire column. edita columna C en letra tamaño 16
            /* 'C'  => ['font' => ['size' => 16]], */
        ];
    }

}
