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
<div id="hellobar-bar" class="regular animated infinite pulse">
    <div class="hb-content-wrapper">
        <div class="hb-text-wrapper">
            <div class="hb-headline-text">
                <p><span > <i class="fa fa-headset"></i> <h4 id="barmessage">Initiating Call</h4></span></p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
@php
$respondent = json_decode($respondent)


@endphp
{{$callsession}}
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
                    <div class="panel-body" id="surveyElement">
                    <survey-show :selectedphone="{{$selectedphone}}" :survey-data="{{ json_encode($survey) }}" :json-data="{{ $incomplete }}"></survey-show>
                    </div>

            </div>
        </div>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
         var hellobar = document.querySelector('#hellobar-bar');
        window.SurveyConfig = {!! json_encode(config('survey-manager')) !!};

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
var sessionId = {{$callsession}};
var barmessage = document.querySelector('#barmessage');
Echo.channel('call_status' + sessionId).listen('ChangeCallStatus', (e)=>{
                // alert(e)
                let statusmessage = document.querySelector("#callstatus");
                let animationdiv = document.querySelector(".call-animation");
                console.log(e)
                toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-bottom-full-width",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
                // statusmessage.innerHTML = e.callstatus
                if(e.callstatus === "NotAnswered"){
                    statusmessage.style.cssText += 'color: red;';
                    animationdiv.style.background = "red";
                    hellobar.style.background = "red";
                    toastr["error"]("Phone Was not Answered . Please try again")
                    barmessage.innerHTML = "Phone not Answered . Please try again";
                     animationdiv.style.border = "solid 5px red";
                    statusmessage.innerHTML = "Phone not Answered"
                }else if(e.callstatus === "Dialing"){
                    statusmessage.style.cssText += 'color: yellow;';
                    animationdiv.style.border = "solid 5px #57a9c1";
                    hellobar.style.color = "#57a9c1";
                    toastr["info"]("Dialing the Respondent");
                    barmessage.innerHTML = "Dialing the Respondent";
                    animationdiv.style.background = "#57a9c1";
                    statusmessage.innerHTML = "Dialing the Respondent"
                }else if (e.callstatus === "Bridged") {
                    statusmessage.style.cssText += 'color: green;';
                    animationdiv.style.border = "solid 5px green";
                    toastr["success"]("Connected with  the Respondent");
                    hellobar.style.background = "green";
                    barmessage.innerHTML = "Connected with the Respondent";
                    animationdiv.style.background = "green";
                    statusmessage.innerHTML = "Connected with the Respondent"
                }else if (e.callstatus === "Completed") {
                    statusmessage.style.cssText += 'color: white;';
                    animationdiv.style.border = "solid 5px green";
                    hellobar.style.background = "green";
                    toastr["success"]("Phone Call Completed");
                    barmessage.innerHTML = "Call Completed";
                    hellobar.style.display = "None";
                    animationdiv.style.background = "green";
                    statusmessage.innerHTML = "Connected with the Respondent"
                }
            })
        }

    </script>

    <script src="{{ asset('vendor/survey-manager/js/survey-front.js') }}"></script>
@endsection
