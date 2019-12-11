<?php

namespace App\Exports;

use App\Respondent;
use Maatwebsite\Excel\Concerns\FromCollection;

class RespondentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Respondent::all();
    }
}
