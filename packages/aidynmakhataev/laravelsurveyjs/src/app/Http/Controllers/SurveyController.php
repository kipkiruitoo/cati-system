<?php

namespace AidynMakhataev\LaravelSurveyJs\app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Auth;
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

        return view('survey-manager::survey', [
            'survey'    =>  $survey,
            'respondent' => $request->respondent,
            'agent' => Auth::user()->id,
        ]);
    }
}
