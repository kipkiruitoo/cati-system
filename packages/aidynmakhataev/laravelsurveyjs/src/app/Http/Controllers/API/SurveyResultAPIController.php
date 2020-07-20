<?php

namespace AidynMakhataev\LaravelSurveyJs\app\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interview;
use App\Feedback;
use App\Incomplete;
use App\Spedule;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use AidynMakhataev\LaravelSurveyJs\app\Models\Survey;
use AidynMakhataev\LaravelSurveyJs\app\Http\Resources\SurveyResource;
use AidynMakhataev\LaravelSurveyJs\app\Http\Resources\SurveyResultResource;
use App\Respondent;

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
    public function show(Survey $survey, $interview)
    {
        $inter = Interview::find($interview);
        $results = $survey->results()->where('interview', $interview)->get()->first();
        // return SurveyResultResource::collection($results);
        // dd($results);

        return array("result" => $results->json, "survey" => $survey);
        //     ->additional(['meta' => [
        //         'survey'    =>  new SurveyResource($survey),
        //     ]]);
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

        $interview = new Interview;
        $agent = (object) $request->input('agent');
        $respondent = $request->input('respondent');
        //  print_r($agent->agent);
        //  echo "<br><hr>";

        Spedule::where('respondent_id', $respondent)->delete();
        // $res->interviews()->delete();
        // $res->spedules()->delete();
        // $res->save();
        // $respondent = json_decode($respondent->respondent);
        //  print_r($respondent) ;
        // print_r($request->input('project'));
        $interview->agent = $agent->agent;
        $interview->survey = $request->input('survey');
        $interview->phonenumber = $request->input('phonenumber');
        $interview->project = $request->input('project');
        $interview->start_time
            = $request->input('start_time');

        $interview->end_time =
            $request->input('end_time');
        $interview->call_session = $request->input('callsession');
        $interview->respondent = $respondent;
        $interview->date = $request->input('date');
        if ($interview->save()) {
            $result = $survey->results()->create([

                'json'          =>  $request->input('json'),
                'interview' => $interview->id,
                'ip_address'    =>  $request->ip(),
            ]);
            DB::table('incomplete')->where('respondent', '=', $respondent)->delete();
            DB::insert('insert into feedback (respondent_id, feedback, agent) values (?, ?, ?)', [$respondent, 'Successful', Auth::id()]);
        } else {
            $result = "An error occured";
        }

        //  print($interview->id);

        return response()->json([
            'data'      =>  $result,
            'message'   =>  'Survey Result successfully created',
        ], 201);
    }
}
