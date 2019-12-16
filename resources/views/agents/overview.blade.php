@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <div class="well">
            <h4>Total Number of Interviews :</h4>
            <p>{{sizeof($interviews)}}</p>
        </div>
        
    </div>
    <div class="row">
        {!! $interviewchart->html()!!}
    </div>
</div>
{!! Charts::scripts() !!}
{!! $interviewchart->script( ) !!}
@endsection