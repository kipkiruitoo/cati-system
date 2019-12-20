@extends('voyager::master')

@section('content')

<div class="container">
    <div class="row">
     <button class="btn btn-dark" onclick="location.reload()">Refresh</button>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form">
            <div class="form-group">
                <label for="respondent">Selected Respondent</label>
                <div class="well">
                    <h5>{{$respondent[0]->name}}</h5>
                    <h6><span>Phone Number: </span>{{$respondent[0]->phone}}</h6>
                    <h6><span>County: </span>{{$respondent[0]->county}}</h6>
                    <button class="btn btn-dark btn-small">Manage Phone Numbers</button>

                </div>


            </div>
        </div>
        <form action="{{route('survey-manager.run', $survey)}}" method="POST">
            @csrf
            <input type="hidden" name="respondent" value="{{$respondent}}">
            <button type="submit" class="btn btn-dark">Start
                Survey</button>
        </form>
        </div>
        <div class="col-md-6">
             <div class="well">
                    <h5>Last Feedback:</h5>
                    <button class="btn btn-dark btn-small" data-toggle="modal" data-target="#feedback">Add
                        Feedback</button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedback as $feedback)
                            <tr>
                                <td>
                                    {{ $feedback->created_at}}
                                </td>
                                <td>
                                    {{ $feedback->feedback}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>

    </div>
    <div class="row">


    </div>

</div>
<!-- feedback modal -->
<!-- Modal -->
<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Feedback for this Respondent: {{$respondent[0]->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/add-feedback')}}" id="feedbackform" method="POST">
                @csrf
            <div class="modal-body">

                    <div class="form-group">
                        <textarea type="text" id="fback" name="feedback" class="form-control"></textarea>
                    </div>
                    <input type="hidden" id="respondent" name="respondent" value="{{$respondent[0]->id}}">
                    <input type="hidden" name="survey" value={{$survey}}>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
             </form>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        var count = localStorage.getItem("count");
        if (count === 2) {
            localStorage.setItem("count", 0);
            location.reload();
        }
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
<script type="text/javascript">
    // For adding the token to axios header (add this only one time).
    var token = document.head.querySelector('meta[name="csrf-token"]');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

    function addfeedback() {
        var feedback = document.getElementById("fback").value
        var respondent = document.getElementById("respondent").value

        console.log(feedback)

        // send contact form data.
        axios.post('/add-feedback', {
            feedback: feedback,
            respondent: respondent
        }).then((response) => {
            console.log(response)
        }).catch((error) => {
            console.log(error.response.data)
        });
    }

</script>
@endsection
