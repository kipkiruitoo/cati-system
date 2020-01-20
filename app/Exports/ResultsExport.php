<?php

namespace App\Exports;

use AidynMakhataev\LaravelSurveyJs\app\Models\SurveyResult;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResultsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SurveyResult::all()->pluck('json');
    }
}
