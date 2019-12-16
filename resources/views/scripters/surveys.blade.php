@extends('voyager::master')

@section('content')

<div class="container">
    <div class="row">
        <h2>These are the Surveys Related to this Project</h2>
        <a href="{{route('screatesurveyform', $id)}}"><button class="btn btn-primary">Create a New Survey</button></a>
    </div>
    <div class="row">
        <table class="table">
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
                            <label class="btn btn-dark badge" data-toggle="modal" data-target="#status{{$survey->id}}">
                                {{ucfirst($survey->stage)}} </label>
                        </p>

                    </td>
                    <td>{{$survey->version}}</td>
                    <td>
                        <!-- <a href="{{url('/survey', $survey->slug)}}" target="_blank"><button
                                class="btn btn-success">View</button></a> -->
                        @if($survey->stage == "draft")
                        <a href="{{url('/admin/survey',$survey->id )}}" target="_blank"><button
                                class="btn btn-warning">Script</button></a>
                        @else
                        <p>Surveys in Production or Test Stage cannot be edited</p>
                        @endif

                    </td>

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
                                        <select class="form-control" name="stage" id="stage">
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
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
