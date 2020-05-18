@extends('voyager::master')
@section('head')
<style>
@media print {
  a, .np {
    display: none;
  }
}
    </style>
@endsection
@section('content')
<div class="row">
    <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="col-xs-4 col-sm-6 col-md-4">
                    <address>
                        {{-- <strong>TIFA RESEARCH Limited</strong>
                        <br>
                        The Campus, Kabasiran --}}
                        <br>
                        Nairobi, Nairobi Area KE 00511
                        <br>
                        {{-- <abbr title="Phone">P:</abbr> (213) 484-6829 --}}
                    </address>
                </div>
                <div class="col-xs-4 col-sm-6 col-md-4 text-right">
                    <img src="{{asset('lexeme.png')}}" width=160 height=135 alt="">
                </div>
                <div class="col-xs-4 col-sm-6 col-md-4 text-right">
                    <p>
                        <em>{{Carbon\Carbon::now()->timezone("Africa/Nairobi")->toDateTimeString()}}</em>
                    </p>
                    <p>
                    <em>Project: {{$name}}</em>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <h1>Calls Billing Structure</h1>
                </div>
                </span>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>#</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-9"><em>Interviews</em></h4></td>
                            <td class="col-md-1" style="text-align: center"> {{$interview_count}}</td>
                        <td class="col-md-1 text-center"> 0</td>
                            <td class="col-md-1 text-center">KES: 0</td>
                        </tr>
                        <tr>
                            <td class="col-md-9"><em>Calls</em></h4></td>
                            <td class="col-md-1" style="text-align: center">Total Number of Calls: {{$calls_count}}</td>
                        <td class="col-md-1 text-center">Total Call duration: {{$calls_avg_duration/ 60}} minutes</td>
                            <td class="col-md-1 text-center">KES {{$calls_sum}}</td>
                        </tr>
                        <tr>
                            <td>
                          <a  href="{{route('callsexcel', $project)}}"> <button class="btn btn-dark">Get Detailed Call Structure</button> </a>
                            </td>

                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td class="text-right">
                            <p>
                                <strong>Subtotal: </strong>
                            </p>
                            </td>
                            <td class="text-center">
                            <p>
                                <strong> KES {{$calls_sum}}</strong>
                            </p>
                           </td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td class="text-right"><h4><strong>Total: </strong></h4></td>
                            <td class="text-center text-danger"><h4><strong>KES {{$calls_sum}}</strong></h4></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success btn-lg btn-block np" onclick="print()">
                    Print Billing  <span class="glyphicon glyphicon-chevron-right"></span>
                </button></td>
            </div>
</div>
@endsection
