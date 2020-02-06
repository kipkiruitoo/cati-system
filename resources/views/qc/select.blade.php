@extends('voyager::master')

@section('content')
<div class="container">
       <div class="row">
        <div class="well">
            <p>Welcome</p>
            <p>Please pick a Project</p>
        </div>
    </div>
       <div class="row">
        <form action="{{route('projectselected')}}" method="POST" >
        @csrf
            <div class="form-group">
                <label for="surve">Project</label>
                <select name="project" class="form-control" id="survey">
                    @foreach($projects as $project)
                <option value="{{$project->project_id}}">{{$project->name}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Next</button>
            </div>

        </form>
    </div>
</div>
@endsection
