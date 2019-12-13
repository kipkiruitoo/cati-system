@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <div class="form-group">
                    <label for="shift">Day Shift:</label>
                    <select name="shift" id="shit" class="form-control">
                        <option value="1">Morning Shift</option>
                        <option value="1">Afternoon Shift</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date">
                </div>
    </div>
</div>
@endsection