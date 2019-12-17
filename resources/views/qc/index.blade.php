@extends('voyager::master')

@section('content')

<div class="container">
    <div class="row">
        <div class="well">
            <p>Welcome</p>
            <p>Please pick a date below</p>
        </div>
    </div>
    <div class="row">
        <form action="{{url('/qc')}}" method="POST" >
        @csrf
            <div class="form-group">
                <input class="form-control" type="date" name="date">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Next</button>
            </div>
            
        </form>
    </div>
</div>

@endsection