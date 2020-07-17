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
        {{-- <button class="btn btn-dark" onclick="window.print()">Export Excel</button> --}}
        {{-- <button type="copy"> Copy</button> --}}
         <button type="csv" class="btn btn-dark" onclick="exportTableToExcel('tblData')"> Excel\Csv</button>
    </div>
    <div class="row">
@php

    @endphp
    <table class="table table-bordered" id="tblData">
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
                <th>QC name</th>
            </tr>
        </thead>
    <tbody>
        @php
        //    dd($qcresults);
        @endphp

        @foreach ($qcresults as $item)
        @php
        // dd($item->interview);
         $interview = \App\Interview::find($item->interview);
        // dd($interview);
        // dd($interview);
         $qcer =  \App\User::find($item->qc)->name;
        $agent = \App\User::find($interview->agent);
        $respondent = \App\Respondent::find($interview->respondent);
        $item = (object) json_decode($item->json, true);

        // dd($item);

        // dd($qcer)
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
            <td>{{$qcer}}</td>
        </tr>
        @endforeach
    </tbody>
    <table>
    </div>

</div>
@php

@endphp

<script>
    function exportTableToExcel(tableID, filename = '{{$project}}'){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }
}


</script>
        @endsection
