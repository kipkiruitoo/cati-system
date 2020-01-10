@extends('voyager::master')
@section('head')
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
@endsection
@section('content')
<h4>These are the projects you have been assigneed by the Project Manager</h4>

<div class="container">
     <div class="row">
        <table class="table" id="projects">
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
