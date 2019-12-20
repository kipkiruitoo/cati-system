@extends('voyager::master')
@section('head')
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <h4>Add a new Project</h4>
    </div>
    <div class="row">
        <div class="card ">
            <div class="card-content ">
                <form action="{{route('projects.store')}}" method="post">
                    @csrf

                    <div class="form-group m-l-10">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                            placeholder="Enter Name" required>
                        <small id="nameHelp" class="form-text text-muted">Name of the Project</small>
                    </div>
                    <div class="form-group p-l-10">
                        <label for="name">Start Date</label>
                        <input type="date" class="form-control" id="sdate" name="sdate" aria-describedby="nameHelp"
                            required>
                        <small id="nameHelp" class="form-text text-muted">Expected start date of the project</small>
                    </div>
                    <div class="form-group">
                        <label for="name">End Date</label>
                        <input type="date" class="form-control" id="edate" name="edate" aria-describedby="nameHelp"
                            required>
                        <small id="nameHelp" class="form-text text-muted">Expected end date of the project</small>
                    </div>
                    <div class="form-group">
                        <label for="name">Assign Supervisors</label>
                        <select class="form-control js-example-basic-multiple" id="supervisors" name="supervisors[]" aria-describedby="nameHelp" multiple required>
                            @foreach($sups as $sup)
                            <option value="{{$sup->id}}">{{$sup->name}}</option>
                            @endforeach
                        </select>
                        <small id="nameHelp" class="form-text text-muted">Assign supervisors to this
                            project. Press Ctrl and click to add more than one supervisor</small>
                    </div>
                    <div class="form-group">
                    <label for="name">Assign a Scripting Agent</label>
                        <select class="form-control" id="supervisors"  name="sa" aria-describedby="nameHelp" required>
                            @foreach($sas as $sup)
                            <option value="{{$sup->id}}">{{$sup->name}}</option>
                            @endforeach
                        </select>
                        <small id="nameHelp" class="form-text text-muted">Assign a scripting agent  to this
                            project. Press Ctrl and click to add more than one Scripting Agent</small>
                    </div>
                     <div class="form-group">
                        <label for="name">Assign a Qualicty Assurance Agent</label>
                        <select class="form-control " name="qcs[]" multiple id="supervisors" name="qcs"
                            aria-describedby="nameHelp" required>
                            @foreach($qcs as $sup)
                            <option value="{{$sup->id}}">{{$sup->name}}</option>
                            @endforeach
                        </select>
                        <small id="nameHelp" class="form-text text-muted">Assign a scripting agent to this
                            project. Press Ctrl and click to add more than one Scripting Agent</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary  btn-block">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
        $('#scripters').select2();
    });

</script>
@endsection
