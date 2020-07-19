@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <th>Interviewer</th>
                <th>Respondent</th>
                <th>Date of Consumption</th>
                <th>Date of interview</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($interviews as $interview)
                <tr>
                    <td>{{App\User::find($interview->agent)->name}}</td>
                    <td>@if (App\Respondent::where('id',$interview->respondent)->exists())
                        {{App\Respondent::find($interview->respondent)->name}}
                    @else
                        Deleted Respondent
                    @endif

                    </td>
                    <td>{{$interview->date}}</td>
                    <td>{{$interview->created_at}}</td>
                    <td>
                        <a href="{{url('/qc/' . $interview->survey .'/results/' . $interview->id)}}"><button
                                class="btn btn-dark">Show Results</button></a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>
</div>
<script>
    window.onload = function (){
        let load = localStorage.getItem("reload");
        if (load === "true") {
            toastr["info"]("Removing QCd interviews, please wait");
            localStorage.setItem("reload", false);
            window.setTimeout(function(){
               location.reload();
            }, 100);

        }
    }

</script>
@endsection
