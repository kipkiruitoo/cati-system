@extends('voyager::master')

@section('content')
@php 
$respondent = json_decode($respondent)
@endphp
    <div class="container">
        <div class="row">
            <h4>You Are interviewing:</h4>
            <div class="well">
                Name: <p>{{$respondent[0]->name}}</p>
                Phone Number: <p>{{$respondent[0]->phone}}</p>
                County: <p>{{$respondent[0]->county}}</p>
            </div>
        </div>
        <div class="row">
                    <div class="panel-body" id="surveyElement">
                        <survey-show :survey-data="{{ json_encode($survey) }}"></survey-show>
                    </div>
                
            </div>
        </div>

    <script>
        window.SurveyConfig = {!! json_encode(config('survey-manager')) !!};
    </script>

    <script src="{{ asset('vendor/survey-manager/js/survey-front.js') }}"></script>
@endsection
 