@extends('voyager::master')

@section('content')

<div class="container">
    <div class="row">
        <h4>Add a new Project</h4>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-content">
                <form action="{{route('projects.store')}}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                            placeholder="Enter Name">
                        <small id="nameHelp" class="form-text text-muted">Name of the Project</small>
                    </div>
                    <div class="form-group">
                        <label for="name">Start Date</label>
                        <input type="date" class="form-control" id="sdate" name="name" aria-describedby="nameHelp">
                        <small id="nameHelp" class="form-text text-muted">Expected start date of the project</small>
                    </div>
                    <div class="form-group">
                        <label for="name">End Date</label>
                        <input type="date" class="form-control" id="edate" name="name" aria-describedby="nameHelp">
                        <small id="nameHelp" class="form-text text-muted">Expected end date of the project</small>
                    </div>
                    <div class="form-group">
                        <label for="name">Supervisor</label>
                        <select class="form-control" id="name" name="supervisor" aria-describedby="nameHelp">
                            @foreach($pms as $pm)
                            <option value="{{$pm->id}}">{{$pm->name}}</option>
                            @endforeach
                        </select>
                        <small id="nameHelp" class="form-text text-muted">Name of the Project</small>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

@endsection
