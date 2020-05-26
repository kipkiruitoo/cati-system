@extends('voyager::master')
@section('head')
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <h2>These are the Surveys Related to this Project</h2>
        <a href="{{route('screatesurveyform', $id)}}"><button class="btn btn-primary">Create a New Survey</button></a>
    </div>
    <div class="row">
        <table class="table" id="surveys">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Stage</th>
                    <th>version</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($surveys as $survey)
                <tr>
                    <td>
                        {{$survey->id}}
                    </td>
                    <td>
                        {{$survey->name}}
                    </td>
                    <td>
                        <p class="mb-0 mt-1 text-muted btn-group">
                            <label class="btn btn-success badge">
                                Stage </label>
                            <label class="btn btn-dark badge" data-toggle="modal" data-target="#staus{{$survey->id}}">
                                {{ucfirst($survey->stage)}} </label>
                        </p>

                    </td>
                    <td>{{$survey->version}}</td>
                    @if($survey->stage == "draft")
                    <td>
                        <!-- <a href="{{url('/survey', $survey->slug)}}" target="_blank"><button
                                class="btn btn-success">View</button></a> -->

                        <a href="{{url('/admin/survey',$survey->id )}}" target="_blank"><button
                                class="btn btn-warning">Script</button></a>


                    </td>
                    <td>
                        <p>You cannot Download Results When in draft mode</p>
                    </td>

                     @else
                     <td>
                          <p>Change the stage back to draft to edit it. </p>
                     </td>
                      <td>
                          {{$survey->id}}

                        <button class="btn btn-info" data-toggle="modal" data-target="#filter{{$survey->id}}">Download
                            results</button>
                        <a href="{{route('analytics', $survey->id )}}" target="__blank"><button class="btn btn-info"> Analytics</button></a>

                    </td>

                        @endif

                </tr>
                <!-- Modal -->
                <div class="modal fade" id="status{{$survey->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="estatus{{$survey->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('changestatus', $survey->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">

                                    <div class="form-group">
                                        <select class="form-control" name="stage" id="stage{{$survey->id}}">
                                            <option value="draft">Draft</option>
                                            <option value="test">Test</option>
                                            <option value="production">Production</option>
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
                {{-- filter modal --}}
                <div class="modal fade" id="filter{{$survey->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="estatus{{$survey->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{route('getresults')}}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h4>Choose data for interviews done between these dates</h4> <strong>Beta</strong>
                                    <h6>The data will be downloaded in csv format for the period specified.</h6>
                                </div>
                                <div class="modal-body">


                                    <div class="row">
                                        <div class="col col-md-6">
                                            <div class="form-group">

                                                <label for="date1{{$survey->id}}">This date</label>
                                                <input type="date" class="form-control" name="from"
                                                    id="date1{{$survey->id}}">

                                            </div>
                                        </div>
                                        <input type="hidden" name="survey" value="{{$survey->id}}">
                                        <div class="col col-md-6">
                                            <div class="form-group">

                                                <label for="date2{{$survey->id}}">To This date</label>
                                                <input type="date" class="form-control" name="to"
                                                    id="date2{{$survey->id}}">

                                            </div>
                                        </div>

                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name = "submit" class="btn btn-primary" value="csv" >CSV</button>
                                    <button type="submit" name = "submit" class="btn btn-dark" value="json" >JSON</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                @endforeach
            </tbody>
        </table>
    </div>

</div>
<script>
    // $(document).ready(function () {
    //     $('#surveys').DataTable();
    // });

</script>
@endsection
