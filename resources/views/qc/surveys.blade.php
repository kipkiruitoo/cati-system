@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <div class="well">
            <p>Welcome</p>
            <p>Please pick a Survey and date below and Click on Next</p>
            <p>If you cannot see a survey, contact your project manager</p>
        </div>
    </div>
    <div class="row">
        <form action="{{url('/qc')}}" method="POST" >
        @csrf
            <div class="form-group">
                <label for="surve">Survey</label>
                <select name="survey" class="form-control" id="survey">
                    @foreach($surveys as $survey)
                <option value="{{$survey->id}}">{{$survey->name}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input class="form-control" id="date" type="date" name="date">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Next</button>
            </div>

        </form>
    </div>
</div>
@endsection
