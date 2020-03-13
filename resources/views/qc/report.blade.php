@extends('voyager::master')
@section('head')
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/datatables.min.js"></script>

@endsection
@section('content')
<div class="container">
    <div class="row">
        <button class="btn btn-dark" onclick="window.print()">Export PDF</button>
        <button type="copy"> Copy</button>
         <button type="csv"> Csv</button>
    </div>
    <div class="row">
@php

    @endphp
    <table class="table" id="reports">
        <thead>
            <tr>
                <th>Interview Id</th>
                <th>Agent Name</th>
                <th>Respondent ID</th>
                <th>Phone Called</th>
                <th>Respondent Name</th>
                <th>Interview Date</th>
                <th>Script Compliant</th>
                <th>Language</th>
                <th>Integrity</th>
                <th>Interviewee audible</th>
                <th>interviewee responsive</th>
                <th>Interview Complete?</th>
            </tr>
        </thead>
    <tbody>
        @foreach ($qcresults as $item)
        @php
         $interview = \App\Interview::find($item->interview);
        // var_dump($interview);
        $agent = \App\User::find($interview->agent);
        $respondent = \App\Respondent::find($interview->respondent);
        $item = (object) json_decode($item->json, true);
        // var_dump($item);
        @endphp
        <tr>
            <td>{{$interview->id}}</td>
            <td>{{$agent->name}}</td>
        <td>{{$interview->respondent}}</td>
        <td>{{$interview->phonenumber}}</td>
        <td>{{$respondent->name}}</td>
            <td>{{$interview->created_at}}</td>
            <td>{{$item->sc? 'Yes': 'No'}}</td>
            <td>{{$item->language? 'Correct': 'Incorrect'}}</td>
            <td>{{$item->integrity? 'Yes': 'No'}}</td>
            <td>{{$item->ia? 'Yes': 'No'}}</td>
            <td>{{$item->ir? 'Yes': 'No'}}</td>
            <td>{{$item->ic? 'Yes': 'No'}}</td>
        </tr>
        @endforeach
    </tbody>
    <table>
    </div>

</div>


<script>
 $(document).ready(function () {
       $('#reports').DataTable({
           processing: true,
             dom: 'Bfrtip',
             buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ]
        });

 });
    
</script>
        @endsection
