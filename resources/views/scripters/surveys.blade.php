@extends('voyager::master')

@section('content')

<div class="container">
    <div class="row">
        <h2>These are the Surveys Related to this Project</h2>
        <a href="{{route('createsurvey', $id)}}"><button class="btn btn-primary">Create a New Survey</button></a>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                   <th>Id</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($surveys as $survey)
                    <tr>
                        <td>
                            {{$survey->id}}
                        </td>
                        <td>
                            {{$survey->name}}
                        </td>
                        <td>
                            <a href="{{url('/survey', $survey->slug)}}" target="_blank"><button class="btn btn-success">View</button></a>
                            <a href="{{url('/admin/survey',$survey->id )}}" target="_blank"><button class="btn btn-warning">Script</button></a>
                            
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</div>
@endsection