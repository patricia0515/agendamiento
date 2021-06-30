<?php

namespace App\Exports;

use App\Master;
use Maatwebsite\Excel\Concerns\FromCollection;
/* Poseciona un encabezado */

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

class ReportesExport implements  FromQuery, WithHeadings, ShouldAutoSize, WithStyles
{


    public function __construct($idmaster, $gestiones)
    {
        $this->idmaster = $idmaster;
        $this->gestiones = $gestiones.'2021-01-01'.'2021-01-02';
    }
    
   
    use Exportable;

    public function query()
    
    {
        return Master::query('idmaster','nombre_persona','apellido_persoa')
            ->where('idmaster', $this->idmaster)
            ->orderBy('idmaster', 'desc');
    }

    public function headings(): array
    {
        return [
            'IDMaster',
            'NOMBRE',
            'APELLIDO'
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
