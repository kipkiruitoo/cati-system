@extends('voyager::master')
@section('head')
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
@endsection
@section('content')
@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3 )
<div class="container">
    <div class="row">
        <div class="col-sm-6">
<a href="{{route('projects.create')}}"><button class="btn btn-primary">Add a New Project</button></a>
        </div>
        <div class="col-sm-6">
            <div class="well">
                <div class="card">
    <div class="card-body">
        Phone Credit Balance is: <span class="cash font-weight-bold font-italic" id="cash"></span>
    </div>
</div>
            </div>

        </div>


    </div>
    <div class="row">
        <table class="table" id="projects">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Project Manager</th>
                    {{-- <th>Assign Client</th> --}}
                    {{-- <th>Respondents</th> --}}
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
                    <td>{{ \App\User::find( $project->pm)->name}}</td>
{{--
                    <td>
                        @if($project->client)
                        {{ App\Client::find($project->client)->name}}
                        @else
                        <button class="btn btn-dark btn-small" data-toggle="modal"
                            data-target="#client{{$project->id}}">Assign Client </button>
                        @endif
                    </td> --}}
                    {{-- <td>
                        @if($project->respondents)
                        {{App\RespondentTypes::find($project->respondents)->name}}
                        @else
                        <button class="btn btn-dark btn-small" data-toggle="modal"
                            data-target="#resp{{$project->id}}">Assign Respondents </button>
                        @endif
                    </td> --}}
                    <td>{{$project->start_date}}</td>
                    <td>{{$project->end_date}}</td>
                    <td>
                        <a href="{{route('projects.show', $project->id)}}"><button
                                class="btn btn-primary">Show</button></a>
                    </td>
                    <td>
                        <a href="{{route('projects.edit', $project->id)}}"><button
                                class="btn btn-warning">Edit</button></a>
                    </td>
                     <td>
                        <a href="{{route('billing', $project->id)}}"><button
                                class="btn btn-primary">Billing</button></a>
                    </td>
                    <td>
                        <form action="{{ route('projects.destroy',$project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')<button type="submit" class="btn  btn-danger">Delete</a>
                        </form>
                    </td>

                </tr>


                @endforeach
            </tbody>
        </table>
    </div>
</div>
@foreach($projects as $project)
 <!-- clients modal -->
                <div class="modal fade" id="client{{$project->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="client{{$project->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Choose a Client to assign to this project
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('assignclients', $project->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">

                                    <div class="form-group">
                                        <select class="form-control" name="client" id="stage">
                                            @foreach($clients as $client)
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
                </div>
                <!-- end clients modal -->
                <!-- respondents modal -->
                <div class="modal fade" id="resp{{$project->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="resp{{$project->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('assignrespondents', $project->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">

                                    <div class="form-group">
                                        <select class="form-control" name="respondent" id="stage">
                                            @foreach($respondents as $respondent)
                                            <option value="{{$respondent->id}}">{{$respondent->name}}</option>
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
                </div>
                <!-- end respondents modal -->
@endforeach
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
<script>

window.setInterval(function(){
let walletdom = document.getElementById("cash");
        let url = "{{ route('walletbalance')}}";

        axios.get(url).then(result=>{
            console.log(result.data.UserData.balance)
            walletdom.innerHTML = result.data.UserData.balance
        }).catch(error =>{
            console.log(error)
        });
}, 6000);
      var token = document.head.querySelector('meta[name="csrf-token"]');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
   $(document).ready(function () {
        // $('#projects').DataTable();

getwalletbalance();


    });

    function getwalletbalance(){
let walletdom = document.getElementById("cash");
        let url = "{{ route('walletbalance')}}";

        axios.get(url).then(result=>{
            console.log(result.data.UserData.balance)
            walletdom.innerHTML = result.data.UserData.balance
        }).catch(error =>{
            console.log(error)
        });
        // console.log('called')
    }

</script>

@else
<p>You are not allowed to view this page</p>
@endif
@endsection
