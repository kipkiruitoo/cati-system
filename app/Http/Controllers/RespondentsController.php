<?php

namespace App\Http\Controllers;

use App\Respondent;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class RespondentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project)
    {
        $respondents = Respondent::where('project', $project)->paginate(30);
        $columns = Schema::getColumnListing('respondents'); // users table
        // dd($columns); 
        return view('respondents.index', compact('respondents', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function show(Respondent $respondent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function edit(Respondent $respondent)
    {
        //
    }
     public function runquery(Request $request)
    {
        // dd($request);
        $action = $request->action;
        $query = $request->query;
        $equals = $request->equals;
        if ($action == 'activate') {
           dd($action);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Respondent $respondent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Respondent $respondent)
    {
        //
    }
}
