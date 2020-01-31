@extends('voyager::master')
@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" type="text/css" rel="stylesheet" />
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/easy-autocomplete"></script>
        <link rel="stylesheet" href="https://unpkg.com/easy-autocomplete@1.3.5/dist/easy-autocomplete.css"/>
          <script src="https://unpkg.com/emotion-ratings@2.0.1/dist/emotion-ratings.js"></script>
@stop
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

        window.onload = function () {
$('form').on('focus', 'input[type=number]', function (e) {
  $(this).on('wheel.disableScroll', function (e) {
    e.preventDefault()
  })
})
$('form').on('blur', 'input[type=number]', function (e) {
  $(this).off('wheel.disableScroll')
})
        }
    </script>

    <script src="{{ asset('vendor/survey-manager/js/survey-front.js') }}"></script>
@endsection
