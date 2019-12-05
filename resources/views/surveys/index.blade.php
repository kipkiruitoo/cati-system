@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <a href="{{route('surveys.create')}}"><button class="btn btn-primary">Add a NEw Survey</button></a>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Project</th>
                </tr>
            </thead>
        </table> 

    </div>
</div>
@endsection
