@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <form action="{{route('screatesurvey')}}" class="m-t-60" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="name" id="name" placeholder="Name of the Suurvey" class="form-control">
            </div>
            <div class="form-group">
                <input type="number" name="num" id="num" placeholder="Number of interviews per respondent" class="form-control">
            </div>
            <input type="hidden" name="project" value="{{$id}}">
            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-primary">
            </div>
        </form>

    </div>
</div>
@endsection
