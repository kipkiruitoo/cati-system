<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Projects;
use App\Respondent;
use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;



use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    
    public function firstpage(){

        $projects = DB::table('projects')->join('projects_agents', 'projects_agents.project_id', '=', 'projects.id')->where('projects_agents.user_id', Auth::user()->id)->get();

        return view('agents.index', compact('projects'));
    }

    public function secondpage($id){
       
        $surveys = Survey::where('project', $id)->get();


         return view('agents.surveys', compact('surveys'));

    }
    public function thirdpage(Request $request){

        $survey =  $request->survey;
        $respondent = Respondent::all()->random(1);

        // echo $respondent;

        return view('agents.thirdpage', compact('survey', 'respondent'));
    }
}
