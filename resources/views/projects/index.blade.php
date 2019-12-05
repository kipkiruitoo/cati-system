@extends('voyager::master')

@section('content')

<div class="container">
    <div class="row">
        <a href="{{route('projects.create')}}"><button class="btn btn-primary">Add a NEw Project</button></a>
    </div>
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
                        <a href="{{route('projects.show', $project->id)}}"><button
                                class="btn btn-primary">Show</button></a>
                    </td>
                    <td>
                        <a href="{{route('projects.edit', $project->id)}}"><button
                                class="btn btn-warning">Edit</button></a>
                    </td>
                    <td>
                        <form action="{{ route('projects.destroy',$project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')<button type="submit" class="btn  btn-danger">Delete</a>
                        </form>
                    </td>

                </tr>
                <hr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
