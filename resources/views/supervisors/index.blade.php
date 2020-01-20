@extends('voyager::master')

@section('content')
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
                    <td>{{$project->project_id}}</td>
                    <td>{{$project->name}}</td>
                    <td>{{ \App\User::find( $project->pm)->name}}</td>
                    <td>{{$project->start_date}}</td>
                    <td>{{$project->end_date}}</td>
                    <td>
                        <a href="{{route('projectagents', $project->project_id)}}"><button
                                class="btn btn-primary">Show Agents</button></a>
                    </td>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#test").CreateMultiCheckBox({
            width: '230px',
            defaultText: 'Select Below',
            height: '250px'
        });
    });

</script>


@endsection
