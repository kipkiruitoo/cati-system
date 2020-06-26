@extends('voyager::master')
@section('header')
        <link href="https://surveyjs.azureedge.net/1.7.12/modern.css" type="text/css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"></script>
        <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
        <script src="https://surveyjs.azureedge.net/1.7.12/survey.pdf.js"></script>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <h2>These are the Surveys Related to this Project</h2>
        <a href="{{route('createsurvey', $id)}}"><button class="btn btn-primary">Create a New Survey</button></a>
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
                          <!-- {{$survey->id}} -->
                        <a href="{{route('surveytool', $survey->id)}}">
                        <button class = "btn btn-warning">View Tool</button>
                        </a>
                       <button class="btn btn-success" type="button" id="savepdf" onclick="savepdf({{$survey->id}})"><span><i class="fa fa-plus"></i></span>Generate PDF</button>

                        <button class="btn btn-info" data-toggle="modal" data-target="#filter{{$survey->id}}">Download
                            results</button>
                        <a href="{{route('analytics', $survey->id )}}" target="__blank"><button class="btn btn-info"> Analytics</button></a>

                    </td>

                        @endif
                        <td>
                            <form action="{{ route('surveys.destroy',$survey->id) }}" method="POST">
                            @csrf
                            @method('DELETE')<button type="submit" class="btn  btn-danger">Delete</a>
                        </form>
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
 <script src="https://unpkg.com/jquery"></script>
<script src="https://surveyjs.azureedge.net/1.7.12/survey.jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"></script>
        <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
        <script src="https://surveyjs.azureedge.net/1.7.12/survey.pdf.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>

<script>
    var json;
    function savepdf(survey) {
        console.log(survey);
        let savebtn = document.getElementById('savepdf');
        savebtn.innerHTML = '<span class="animate__animated animate__bounce"><i class="fa fa-spinner fa-spin"> Generating</span>';
        let url = `/survey/structure/${survey}`;
        axios.get(url).then(result=>{
            console.log(result)
            window.survey = new Survey.Model(result.data.json);
            json = result.data.json;
             saveSurveyToPdf(result.data.name, survey);
        });
    }
    function saveSurveyToPdf(filename, surveyModel) {
    var surveyPDF = new SurveyPDF.SurveyPDF(json, {commercial: true});
    surveyPDF.data = surveyModel.data;
    surveyPDF.save(filename);
    let savebtn = document.getElementById('savepdf');
        savebtn.innerHTML = '<span><i class="fa fa-plus"></i></span>Generate PDF';
}
</script>
@endsection