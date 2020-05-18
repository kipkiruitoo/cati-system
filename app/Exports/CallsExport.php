<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Call;
use App\Projects;
use App\Respondent;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CallsExport implements FromQuery, WithHeadings,  withMapping
{

    public $project;

    function __construct($project)
    {
        $this->project = $project;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {

    //     return Projects::find($this->project)->calls()->get();
    // }
    public function map($call): array
    {
        return [
            $call->id,
            $call->session_id,
            $call->respondent,
            ($call->duration / 60),
            ($call->call_duration / 60),
            $call->amount,
            Respondent::find($call->respondent)->name,
            Respondent::find($call->respondent)->phone,
            $call->created_at

        ];
    }
    public function query()
    {
        return  Projects::find($this->project)->calls();
    }

    public function headings(): array
    {
        return [
            ['#', 'Session ID', 'Respondent ID', 'Agent Duration', 'Dial Duration', 'Call Cost', 'Respondent Name', 'Respondent Phone number', 'Created_at'],

        ];
    }
}
