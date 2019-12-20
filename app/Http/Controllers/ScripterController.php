<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use Auth;


use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;

class ScripterController extends Controller
{
 public function index()

    {
        $projects = Projects::where('sa', Auth::user()->id )->get();
        return view('scripters.index', compact('projects'));
    }

     public function surveys($id)

    {
        $project = Projects::findOrFail($id)->first();
        $surveys = Survey::where('project', $id)->get();


        return view('scripters.surveys', compact('surveys', 'id'))->withProject($project);
    }
    public function createsurvey(Request $request){
        $survey =  new Survey;
        $survey->name = $request->name;
        $survey->slug = time();
        $survey->project = $request->project;
        $jsonArray = json_decode('{"pages":[]}');
        $survey->json = $jsonArray;

        if ($survey->save()) {

            return redirect()->route('scriptersurveys', $survey->project);
        }else{
            echo "did not work";
        }
    }
    public function create($id){
 return view('scripters.createsurvey', compact('id'));
    }
    public function changestatus(Request $request, $id){

        $survey = Survey::findOrFail($id);
        $survey->stage = $request->stage;

        if ($survey->save()) {

            return redirect()->back();
        }else{
            echo "Something went wrong";
        }


    }
}
