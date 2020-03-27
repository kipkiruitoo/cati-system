<?php

namespace AidynMakhataev\LaravelSurveyJs\app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Incomplete;
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

        // $incomplete  =  Incomplete::where('id', $request->respondent)->latest()->take(1)->get();
        if (Incomplete::where('respondent', $request->respondent)->exists()) {
            # code...
            $incomplete = Incomplete::where('respondent', $request->respondent)->latest()->take(1)->get();
            $jsondata = $incomplete[0]->json;
            $jsondata = json_encode(json_decode($jsondata));
            // var_dump($jsondata);

        } else {
            $jsondata = "no results";
            $jsondata = json_encode(json_decode($jsondata));
        }

        // print_r($survey) ;
        array_push($survey, ["respondent" => $request->respondent]);
        array_push($survey, ['agent' => Auth::user()->id]);
        return view('survey-manager::survey', [
            'survey'    =>  $survey,
            'incomplete' => $jsondata,
            'respondent' => Respondent::where('id', $request->respondent)->get(),
            'selectedphone' => $request->phonenumber,
            'agent' => Auth::user()->id,
            'callsession' => $request->callsession
        ]);
    }
}
