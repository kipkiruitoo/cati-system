<?php

namespace AidynMakhataev\LaravelSurveyJs\app\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interview;
use AidynMakhataev\LaravelSurveyJs\app\Models\Survey;
use AidynMakhataev\LaravelSurveyJs\app\Http\Resources\SurveyResource;
use AidynMakhataev\LaravelSurveyJs\app\Http\Resources\SurveyResultResource;

class SurveyResultAPIController extends Controller
{
    public function index(Survey $survey)
    {
        $results = $survey->results()->paginate(config('survey-manager.pagination_perPage', 10));

        return SurveyResultResource::collection($results)
                ->additional(['meta' => [
                    'survey'    =>  new SurveyResource($survey),
                ]]);
    }

    /**
     * @param Survey $survey
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Survey $survey, Request $request)
    {
        $request->validate([
            'json'  =>  'required',
        ]);

        // echo $request->input('respondent');
        // Log::debug($request->input('respondent'));

        $result = $survey->results()->create([
            'json'          =>  $request->input('json'),
            'ip_address'    =>  $request->ip(),
        ]);



         $interview = new Interview;
         $agent = (object) $request->input('agent');

         $respondent = (object) $request->input('respondent');

        //  print_r($agent->agent);

        //  echo "<br><hr>";

        $respondent = json_decode($respondent->respondent);

        //  print_r($respondent) ;
        print_r($request->input('project'));
         $interview->agent = $agent->agent;
         $interview->survey = $request->input('survey');
        //  $iinterview->project = $request->input('project');
         $interview->respondent = $respondent[0]->id;
         $interview->date = $request->input('date');

         $interview->save();

        return response()->json([
            'data'      =>  $request->input(),
            'message'   =>  'Survey Result successfully created',
        ], 201);
    }
}
