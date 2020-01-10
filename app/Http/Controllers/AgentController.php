<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Projects;
use App\Respondent;
use App\Interview;
use App\Feedback;
use Charts;
use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;
use App\PanelFeedback;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;

class AgentController extends Controller
{

    public function firstpage()
    {

        $projects = DB::table('projects')->join('projects_agents', 'projects_agents.project_id', '=', 'projects.id')->where('projects_agents.user_id', Auth::user()->id)->get();

        return view('agents.index', compact('projects'));
    }

    public function secondpage($id)
    {

        $surveys = Survey::where('project', $id)->where('stage', '!=', 'draft')->get();


        return view('agents.surveys', compact('surveys'));
    }
    public function thirdpage(Request $request)
    {

        $survey =  $request->survey;
        $respondent = Respondent::all()->random(1);

        $feedbacks = PanelFeedback::all();

        $feedback = Feedback::where('respondent_id', $respondent[0]->id)->latest()->take(5)->get();

        // $lastinterviewdate = Interview::where('respondent', $respondent[0]->id)->latest()->first()->date;
        // echo $respondent;

        return view('agents.thirdpage', compact('survey', 'respondent', 'feedback', 'feedbacks', 'lastinterviewdate'));
    }



    // display the users interview
    public function interviews()
    {
        $interviews = Interview::where('agent', Auth::user()->id)->get();

        return view('agents.interviews', compact('interviews'));
    }

    // overview graphs

    public function overview()
    {

        $interviews = Interview::where(DB::raw("(DATE_FORMAT(created_at,'%m'))"), date('m'))->where('agent', Auth::user()->id)->get();

        // print_r($interviews);

        $interviewchart = Charts::database($interviews, 'line', 'fusioncharts')
            ->title("Your interviews per day")
            ->elementLabel("No of Interviews")
            ->dimensions(600, 500)

            ->groupByDay();
        return view('agents.overview', compact('interviewchart', 'interviews'));
    }

    // add feedback to a client
    public function addfeedback(Request $request)
    {

        DB::table('feedback')->insert(['respondent_id' => $request->input('respondent'), 'feedback' => $request->input('feedback'), 'other' => $request->input('other')]);

        $respondent = Respondent::where('id', $request->input('respondent'))->get();
        $survey = $request->input('survey');
        $feedback = Feedback::where('respondent_id', $respondent[0]->id)->latest()->take(5)->get();
        $feedbacks = PanelFeedback::all();


        $request->survey = $survey;



        return view('agents.thirdpage', compact('respondent', 'survey', 'feedback', 'feedbacks'));
    }

    // public function getthirdpage()
    // {
    //     // $survey =  $id;
    //     // $respondent = Respondent::all()->random(1);

    //     // $feedbacks = PanelFeedback::all();

    //     // $feedback = Feedback::where('respondent_id', $respondent[0]->id)->latest()->take(5)->get();

    //     // $lastinterviewdate = Interview::where('respondent', $respondent[0]->id)->latest()->first()->date;
    //     // echo $respondent;

    //     return view('agents.thirdpage');
    // }


    public function getnewuser()
    {
        $respondent = Respondent::all()->random(1);

        return response()->json($respondent);
    }
}
