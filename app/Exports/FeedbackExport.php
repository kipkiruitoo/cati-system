<?php

namespace App\Exports;

use App\Respondent;
use App\User;
use App\Feedback;
use App\Projects;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeedbackExport implements FromCollection, WithHeadings, withMapping
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public $project;
    public function __construct($project)
    {
        $this->project = $project;
    }
    public function collection()
    {

        return Projects::find($this->project)->feedbacks;
    }

    public function map($feedback): array
    {
        return [
            $feedback->id,
            $feedback->respondent_id,
            Respondent::where('id', $feedback->respondent_id)->exists() ? Respondent::find($feedback->respondent_id)->name : '',
            $feedback->feedback,
            $feedback->agent,
            User::where('id', $feedback->agent)->exists() ? User::find($feedback->agent)->name : '',
            $feedback->other,
            $feedback->created_at

        ];
    }

    public function headings(): array
    {
        return [
            ['#', 'Respondent #', 'Respondent Name', 'Feedback', 'Agent #', 'Agent Name', 'Comment', 'Created_at'],

        ];
    }
}
