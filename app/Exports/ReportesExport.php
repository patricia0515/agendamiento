<?php

namespace App\Exports;

use App\Master;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Master::all();
    }
}
