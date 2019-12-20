<?php

namespace App\Http\Controllers;

use App\Interview;
use App\Projects;

use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;


use Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class QCController extends Controller
{
    public function index()
    {

        $projects = DB::table('projects')->join('qc_projects', 'qc_projects.project_id', '=', 'projects.id')->where('qc_projects.user_id', Auth::user()->id)->get();
        return view('qc.index', compact('projects'));
    }
    public function interviews(Request $request)
    {

        $date = $request->date;
        $survey = $request->survey;

        // echo $date;

        $interviews =  Interview::where('survey', $survey)->where('date', $date)->get();

        return view('qc.results', compact('interviews'));
    }
    public function surveys($id)
    {
        $project = Projects::findOrFail($id)->first();
        $surveys = Survey::where('project', $id)->get();

        return view('qc.surveys', compact('surveys', 'id'))->withProject($project);
        // return view('qc.surveys');
    }
}
