
@extends('voyager::master')
@section('content')
<h4>These are the projects you have been assigneed by the Project Manager</h4>

<div class="container">
     <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Project Manager</th>
                    <th>Start Data</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{$project->id}}</td>
                    <td>{{$project->name}}</td>
                    <td>{{  \App\User::find( $project->pm)->name}}</td>
                    <td>{{$project->start_date}}</td>
                    <td>{{$project->end_date}}</td>
                    <td>
                        <a href="{{route('qcsurveys', $project->project_id)}}"><button
                                class="btn btn-primary">View</button></a>
                    </td>

                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
{{-- @extends('voyager::master')

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

@endsection --}}
