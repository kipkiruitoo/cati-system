@extends('voyager::master')

@section('content')

<div class="container">
    <button class="btn btn-dark" onclick="location.reload()">Refresh</button>
    <div class="row">
        <div class="form">
            <div class="form-group">
                <label for="respondent">Selected Respondent</label>
                <div class="well">
                    <h5>{{$respondent[0]->name}}</h5>
                    <h6><span>Phone Number: </span>{{$respondent[0]->phone}}</h6>
                    <h6><span>County: </span>{{$respondent[0]->county}}</h6>
                    <button class="btn btn-dark btn-small">Manage Phone Numbers</button>

                </div>
                <div class="well">
                    <h5>Last Feedback:</h5>
                    <p>{{App\Interview::where('respondent', $respondent[0]->id)->first()}}</p>
                    <button class="btn btn-dark btn-small">Manage Feedback</button>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <form action="{{route('survey-manager.run', $survey)}}" method="POST">
            @csrf
            <input type="hidden" name="respondent" value="{{$respondent}}">
            <button type="submit" class="btn btn-dark">Start
                Survey</button>
        </form>

    </div>

</div>
@endsection
