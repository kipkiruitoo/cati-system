@extends('voyager::master')

@section('content')

<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <th>Respondent ID</th>
                <th>Respondent Name</th>
                <th>Survey</th>
                <th>Date</th>
                <th>Last Feedback</th>
                <th>Date of Interview</th>
            </thead>
            <tbody>
                @foreach($interviews as $interview)
                <tr>
                    <td>{{App\Respondent::find( $interview->respondent)->res_d}}</td>
                    <td>{{App\Respondent::find( $interview->respondent)->name}}</td>
                    <td>{{AidynMakhataev\LaravelSurveyJs\app\Models\Survey::find($interview->survey)->name ?? "Not Available"}}
                    </td>
                    <td>{{$interview->date}}</td>
                    @php
                        $feedback =App\Feedback::where('respondent_id', $interview->respondent)->latest()->take(1)->first();
                    @endphp
                    <td>{{$feedback['feedback']}}</td>
                    <td>{{$interview->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




@endsection
