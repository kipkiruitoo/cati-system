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
                    <td>{{ \App\User::where('id', $project->pm)->pluck('name')}}</td>
                    <td>{{$project->start_date}}</td>
                    <td>{{$project->end_date}}</td>
                    <td>
                        <a href="{{route('scriptersurveys', $project->id)}}"><button
                                class="btn btn-primary">Show</button></a>
                    </td>
                </tr>
                <hr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection