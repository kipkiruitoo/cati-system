@extends('voyager::master')

@section('content')
<h1>This Page is under development. Do not use it yet</h1>
<div class="container">
<form action="{{route('respondents.query')}}" method="post">
@csrf
<small>You can manage respondent quotas by ctivating or deactivating respondents below </small>
    <div class="row">
    
    
        <div class="col col-md-3">
            <div class="form-group">
            <label for="action">Action</label>
            <select name="action" class="form-control" id="action">
                <option value="activate">Activate</option>
                <option value="deactivate">DeActivate</option>
            </select>
        </div>
        </div>
         <div class="col col-md-3">
            <div class="form-group">
            <label for="where">Where</label>
             <select name="where" class="form-control" id="action">
                @foreach($columns as $column)
                    <option value="{{$column}}">{{$column}}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="col col-md-3">
            <div class="form-group">
            <label for="equals"> </label>
            <select name="equals" class="form-control" id="equals">
                <option value="="> Equals</option>
                <option value="!="> Not Equals </option>
                <option value="!="> Like </option>
            </select>
        </div>
        </div>
         <div class="col col-md-3">
            <div class="form-group">
            <label for="query"> Query</label>
            <input type="text" name="query" id="query" class="form-control">
        </div>
        </div>
   
</div>
<div class="row">
<div class="col col-md-4">
        <button class="btn btn-dark" type="submit">Run </button>
</div>
    
</div>
 </form>
<hr>
<div class="row">
<div class="col col-md-12">
{{$respondents->links()}}
</div>

<table class="table">
<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Phone Number</th>
    <th>Phone Number 2</th>
    <th>Phone Number 3</th>
    <th>Sex</th>
    <!-- <th>lsm</th> -->
    <th>occupation</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
@foreach($respondents as $respondent)
<tr>
<td>{{$respondent->id}}</td>
<td>{{$respondent->name}}</td>
<td>{{$respondent->phone}}</td>
<td>{{$respondent->phone1}}</td>
<td>{{$respondent->phone2}}</td>
<td>{{$respondent->sex}}</td>
<td>{{$respondent->occupation}}</td>
<td>{{$respondent->status}}</td>
<td>
<a href="{{route('voyager.respondents.edit', $respondent->id)}}"><button class="btn btn-success">Edit</button></a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

@endsection