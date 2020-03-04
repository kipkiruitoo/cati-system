@extends('voyager::master')
@section('content')
<div class="container">
    <div class="row">
        <button class="btn btn-dark" onclick="window.print()">Export PDF</button>
    </div>
    <div class="row">
@php

    @endphp
    <table class="table">
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
        @endsection
