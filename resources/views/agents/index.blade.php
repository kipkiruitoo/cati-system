@extends('voyager::master')
@section('head')
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <h3>These are the Projects assigned to you by your Supervisor</h3>
    </div>

    <div class="row">
        <table class="table" id="projects">
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
<script>
 $(document).ready(function () {
        $('#projects').DataTable();
    });
</script>
@endsection
