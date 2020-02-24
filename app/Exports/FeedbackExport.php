<?php

namespace App\Exports;
use App\Respondent;
use App\User;
use App\Feedback;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
class FeedbackExport implements FromQuery, WithHeadings, withMapping
{
   
  /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Feedback::where('id', '>', 0);
    }

     public function map($feedback): array
    {
        return [
            $feedback->id ,
            $feedback->respondent_id, 
            Respondent::where('id', $feedback->respondent_id)->exists()?Respondent::find($feedback->respondent_id)->name : '',
            $feedback->feedback,
            $feedback->agent, 
            User::where('id', $feedback->agent)->exists()? User::find($feedback->agent)->name: '' ,
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