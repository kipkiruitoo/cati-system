@extends('voyager::master')

@section('content')

<div class="container">
    <div class="row">
        <h5>These are the Projects assigned to you by your Supervisor</h5>
    </div>
    <hr>
    <hr>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        name
                    </th>
                    <th>
                        start date
                    </th>
                    <th>
                        end date
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{$project->name}}</td>
                    <td>{{$project->start_date}}</td>
                    <td>{{$project->end_date}}</td>
                    <td>
                        <a href="{{ route('agentchoseproject', $project->project_id)}}"><button type="button"
                                class="btn btn-dark">Interview</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
