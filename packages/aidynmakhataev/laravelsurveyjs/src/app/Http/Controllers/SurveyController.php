<?php

namespace AidynMakhataev\LaravelSurveyJs\app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Respondent;
use AidynMakhataev\LaravelSurveyJs\app\Models\Survey;

class SurveyController extends Controller
{
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    public function runSurvey(Request $request, $slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $survey = $survey->toArray();
        // print_r($survey) ;
        array_push($survey, ["respondent" => $request->respondent]);
        array_push($survey, ['agent' => Auth::user()->id]);
        return view('survey-manager::survey', [
            'survey'    =>  $survey,
            'respondent' => Respondent::where('id', $request->respondent)->get(),
            'selectedphone' => $request->phonenumber,
            'agent' => Auth::user()->id,
        ]);
    }
}
