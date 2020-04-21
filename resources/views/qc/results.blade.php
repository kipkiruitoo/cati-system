@extends('voyager::master')
@section('head')
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="https://unpkg.com/jquery"></script>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/survey-manager/css/survey.css') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/easy-autocomplete"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/easy-autocomplete@1.3.5/dist/easy-autocomplete.css" />

    <link rel="stylesheet" href="{{asset('css/app.css')}}">


    <script src="https://unpkg.com/emotion-ratings@2.0.1/dist/emotion-ratings.js"></script>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <div class="col col-md-6">
            <div class="well">

            <h4>This interview was conducted by : </h4><span>{{ $agent->name}}</span>
        <h4>On:</h4> <span>{{ $interview->created_at}}</span>
            <h4>The date of consumption was: </h4> <span>{{$interview->date}}</span>

        </div>
        </div>
        <div class="col col-md-6">
            <div class="well">
            <h4> The Respondent Was:</h4> <span>{{$respondent->name}}</span>
            <h4>From:</h4> <span>{{$respondent->county}}</span>
            </div>
        </div>


    </div>
    <div class="row">
        {{-- @if($interview->call_session) --}}
        @php
         $audiolinks = App\Call::where('respondent', $interview->respondent)->where('agent', $interview->agent )->get()->pluck('recording_link');
        // echo $audiolink
        // print_r($audiolinks)
         @endphp
         <div class="well">
             <h5>Audio File(s).</h5>
             @foreach ($audiolinks as $audiolink)

             {{-- {{$audiolink}} --}}
         <audio controls src="{{$audiolink}}" download="{{$interview->agent . '_' . $interview->respondent . '_' . $interview->phonenumber }}"  type="audio/mpeg"></audio>
                    <a href="{{$audiolink}}" class="btn btn-dark" download="{{$interview->agent . '_' . $interview->respondent . '_' . $interview->phonenumber }}">Download</a>
                    <hr>
             @endforeach
             {{-- <a download="{{$audiolink}}" class="btn btn-dark">Download Audio File</a> --}}


  {{-- <source src="horse.ogg" type="audio/ogg"> --}}
            </audio>

         </div>

        {{-- @else --}}
        {{-- <audio controls>
                <source src="horse.ogg" type="audio/ogg">
                <source src="horse.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
        </audio> --}}
        {{-- @endif --}}
    </div>
    <div class="row">
        <div class="well">
            Below are the answers entered by the respondents. Go through the audio to acertain the quality of the responces filled!
        </div>
    </div>
    <div id="results">
    <div class="row">

        <survey-result></survey-result>

    </div>
    <hr><hr>
    <h4>Fill in the questionnaire below</h4>
    <div class="row">
    <qc-survey :survey-data="{{ json_encode($survey) }}" :project="{{ $surv->project}}" :qc="{{\Auth::user()->id}}"></qc-survey>
    </div>
    </div>

</div>


<script>
        window.SurveyConfig = {!!json_encode(config('survey-manager')) !!};

    </script>

@endsection
@section('javascript')

<script src="{{asset('js/app.js')}}"></script>
@endsection
