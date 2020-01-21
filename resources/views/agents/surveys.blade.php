@extends('voyager::master')

@section('content')
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
                        <button type="submit" class="btn btn-dark ">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
