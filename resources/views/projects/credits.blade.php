@extends('voyager::master')
@section('content')
<div class="container">
  <div class="row">
    <h4>Remaining Call  Credit:</h4>{{Auth::user()->call_credits}}
    <h4>Remaining Interview Credits:</h4>{{Auth::user()->interview_credits}}
</div>
<div class="row">

</div>
</div>


@endsection
