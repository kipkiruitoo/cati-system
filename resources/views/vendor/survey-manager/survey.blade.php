@extends('voyager::master')
@section('head')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" type="text/css" rel="stylesheet" />
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/easy-autocomplete"></script>
        <link rel="stylesheet" href="https://unpkg.com/easy-autocomplete@1.3.5/dist/easy-autocomplete.css"/>
          <script src="https://unpkg.com/emotion-ratings@2.0.1/dist/emotion-ratings.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

@stop
@section('headbar')

@endsection
@section('content')
@php
$respondent = json_decode($respondent)
@endphp

    <div class="container">
      <div class="row">
      <button  onclick="window.history.back()" class="btn btn-dark"> <span><i class="fa fa-chevron-left"></i> Go Back</span> </button>
      </div>
        <div class="row">
            <h4>You Are interviewing:</h4>
            <div class="well">
                Name: <p>{{$respondent[0]->name}}</p>
                Phone Number: <p>{{$selectedphone}}</p>
                County: <p>{{$respondent[0]->county}}</p>
            </div>
        </div>
        <div class="row">
            <h4>Pause Interview and Continue later</h4>
        <form action="{{route('pauseinterview')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="date">Select Date</label>
                <input type="date" required id="date" name="date" class="form-control">
                <small>This respondent will start appearing a few minutes before the time selected</small>
            </div>
            <div class="form-group">
                <label for="time">Select time to Continue</label>
                <input type="time" required id="time" name="time" class="form-control">
                <small>This respondent will start appearing a few minutes before the time selected</small>
            </div>
            <input type="hidden" name="respondent" name="respondent" value="{{$respondent[0]->id}}">

            @php
                // dd($survey['id']);
            @endphp
            <input type="hidden" name="survey" value="{{$survey['id']}}">
            <div class="form-group">
                <button type="submit" class="btn btn-success">Schedule</button>
            </div>
        </form>
        </div>


        <div class="row">
                    <div class="panel-body" id="surveyElement">
                    <survey-show :selectedphone="{{$selectedphone}}"  :survey-data="{{ json_encode($survey) }}" :json-data="{{ $incomplete }}"></survey-show>
                    </div>

            </div>
        </div>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
         var hellobar = document.querySelector('#hellobar-bar');
        window.SurveyConfig = {!! json_encode(config('survey-manager')) !!};
        window.CallSession = "{{$callsession}}";

        window.onload = function () {
             hellobar.style.display = "table";
$('form').on('focus', 'input[type=number]', function (e) {
  $(this).on('wheel.disableScroll', function (e) {
    e.preventDefault()
  })
})
$('form').on('blur', 'input[type=number]', function (e) {
  $(this).off('wheel.disableScroll')
})
var sessionId = "{{$callsession}}";
// var barmessage = document.querySelector('#barmessage');
Echo.channel('call_status' + sessionId).listen('ChangeCallStatus', (e)=>{
            // alert(e)
                // let statusmessage = document.querySelector("#callstatus");
                // let animationdiv = document.querySelector(".call-animation");
                console.log(e)

                // statusmessage.innerHTML = e.callstatus
                if(e.callstatus === "NotAnswered"){
                    // statusmessage.style.cssText += 'color: red;';
                    // animationdiv.style.background = "red";
                    // hellobar.style.background = "#55040F";
                    toastr["error"]("Phone Was not Answered . Please try again")
                    // barmessage.innerHTML = "Phone not Answered . Please try again";
                    //  animationdiv.style.border = "solid 5px red";
                    // statusmessage.innerHTML = "Phone not Answered"
                }else if(e.callstatus === "Dialing"){
                    // statusmessage.style.cssText += 'color: yellow;';
                    // animationdiv.style.border = "solid 5px #57a9c1";
                    // hellobar.style.background = "#61045A";
                    toastr["info"]("Dialing the Respondent");
                    // barmessage.innerHTML = "Dialing the Respondent";
                    // animationdiv.style.background = "#57a9c1";
                    // statusmessage.innerHTML = "Dialing the Respondent"
                }else if (e.callstatus === "Bridged") {
                    // statusmessage.style.cssText += 'color: green;';
                    // animationdiv.style.border = "solid 5px green";
                    toastr["success"]("Connected with  the Respondent");
                //    hellobar.style.background = "#030B37";
                //     barmessage.innerHTML = "Connected with the Respondent";
                //     animationdiv.style.background = "green";
                //     statusmessage.innerHTML = "Connected with the Respondent"
                }else if (e.callstatus === "Completed") {
                    // statusmessage.style.cssText += 'color: white;';
                    // animationdiv.style.border = "solid 5px green";
                    //  hellobar.style.background = "#033018";
                    toastr["success"]("Phone Call Completed");
                    // barmessage.innerHTML = "Call Completed";
                    // hellobar.style.display = "None";
                    // animationdiv.style.background = "green";
                    // statusmessage.innerHTML = "Connected with the Respondent"
                }
            })
        }

    </script>

    <script src="{{ asset('vendor/survey-manager/js/survey-front.js') }}"></script>
@endsection
