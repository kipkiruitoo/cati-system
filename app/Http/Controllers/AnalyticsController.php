<?php

namespace App\Http\Controllers;
use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;
use Illuminate\Http\Request;
use  AidynMakhataev\LaravelSurveyJs\app\Models\SurveyResult;
class AnalyticsController extends Controller
{
    //

    public function index($id){
        $survey = Survey::where('id', $id)->pluck('json');
        $results = SurveyResult::where('survey_id', $id)->get()->pluck('json');
        // var_dump($results);
        $survey = $survey->toArray();
        $results = $results->toArray();
        // var_dump($results);
        return view('analytics.index', compact('survey', 'results' ));
    }
}
