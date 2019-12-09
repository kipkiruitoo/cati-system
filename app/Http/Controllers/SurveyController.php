<?php

namespace App\Http\Controllers;

// use App\Survey;
use Illuminate\Http\Request;
use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('surveys.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('surveys.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $survey =  new Survey;
       $survey->name = $request->name;
       $survey->slug = time();
       $survey->project = $request->project;
       $jsonArray = json_decode('{"pages":[]}');
       $survey->json = $jsonArray;

       if ($survey->save()) {
           
        return redirect()->route('projects.show', $survey->project);
       }else{
           echo "did not work";
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $pj = Survey::find($id);

        if ($pj->delete()) {
               
        // $projects = Projects::all();


        return redirect()->back();
        }else{

            echo('an error occured while deleting');
        }
    }
}
