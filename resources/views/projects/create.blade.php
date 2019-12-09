@extends('voyager::master')

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
                        <select class="form-control select_multiple" id="supervisors" name="supervisors[]" aria-describedby="nameHelp" multiple required>
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
                        <button type="submit" class="btn btn-primary  btn-block">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function () {
  $("#test").CreateMultiCheckBox({ width: '230px',
             defaultText : 'Select Below', height:'250px' });
});
</script>

@endsection
