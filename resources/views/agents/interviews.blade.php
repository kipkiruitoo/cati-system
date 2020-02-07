@extends('voyager::master')
@section('head')
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <h4>Below is a list of your past interviews</h4>
    </div>
    <div class="row">
        <table class="table" id="interviews">
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
                    <td>{{App\Respondent::find( $interview->respondent)->id?? 'not found'}}</td>
                    <td>{{App\Respondent::find( $interview->respondent)->name?? 'not found'}}</td>
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


<script>
 $(document).ready(function () {
        $('#interviews').DataTable();
    });
</script>

@endsection
