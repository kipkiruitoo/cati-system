@extends('voyager::master')

@section('content')
@php
    if(session()->has('surveys'))
    {
        $surveys = session('surveys');
        $project = session('project');
    }
@endphp
<div class="container">
    <div class="row">
        <h4>Pick a Survey to continue</h4>
    </div>
    <div class="row">
        <div class="col col-md-6 offset-md-6">
            <div class="form">
                <form action="{{route('agentthirdpage')}}" method="POST">
                    @csrf
                    <div class="form-group">

                    <input type="hidden" name="project" value="{{$project}}">
                        <select name="survey" class="form-control" id="">
                            @foreach($surveys as $survey)
                            <option value="{{$survey->slug}}">{{$survey->name}}</option>
                            @endforeach
                        </select>

                        <!-- <input type="text" class="form-control"> -->
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark ">Continue With New Respondent</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="col col-md-6">
        <form action="{{route('agentthirdpage')}}" method="POST">
                     @csrf
                    <div class="form-group">

                    <input type="hidden" name="project" value="{{$project}}">
                        <select name="survey" class="form-control" id="">
                            @foreach($surveys as $survey)
                            <option value="{{$survey->slug}}">{{$survey->name}}</option>
                            @endforeach
                        </select>

                        <!-- <input type="text" class="form-control"> -->
                    </div>
                    <div class="form-group">
                        <label for="phone">Search by Phone Number</label>
                        <input type="tel" id="phone" placeholder="07xxxxxxx" class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-dark " name="search" value="Search"/>
                    </div>
            </form>

        </div>
    </div>
</div>
@endsection
