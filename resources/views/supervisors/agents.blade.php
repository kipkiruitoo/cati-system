@extends('voyager::master')
@section('head')
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

@endsection
@section('content')

<div class="container">
    <div class="row">
        <Button class="btn btn-success" data-toggle="modal"
                            data-target="#client{{$id}}">Add an agent to this project</Button>
        <hr>
        <h2></h2>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agents as $agent)
                <tr>
                    <td>{{$agent->user_id}}</td>
                    <td>{{$agent->name}}</td>
                    <td>
                    <form action="{{route('removeagents', $id)}}" method="post">
                    @csrf
                    <input type="hidden" value="{{$agent->user_id}}" name="agent">
                    <button type="submit" class="btn btn-danger">Remove</button>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="client{{$id}}" tabindex="-1" role="dialog" aria-labelledby="client{{$id}}"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose Agents
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('addagents', $id)}}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <select class="form-control js-example-basic-multiple" style="width: 100%;" name="agents[]" multiple id="stage">
                            @foreach($freeagents as $client)
                            <option value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
        $('#scripters').select2();
    });

</script>


    @endsection
