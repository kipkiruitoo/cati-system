@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <th>Interviewer</th>
                <th>Respondent</th>
                <th>Date of Consumption</th>
                <th>Date of interview</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($interviews as $interview)
                <tr>
                    <td>{{App\User::find($interview->agent)->name}}</td>
                    <td>{{App\Respondent::find($interview->respondent)->name}}</td>
                    <td>{{$interview->date}}</td>
                    <td>{{$interview->created_at}}</td>
                    <td>
                        <a href="{{url('/qc/' . $interview->survey .'/results/' . $interview->id)}}"><button
                                class="btn btn-dark">Show Results</button></a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
