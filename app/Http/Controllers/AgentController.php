<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Call;
use App\Projects;
use App\Respondent;
use App\Interview;
use App\Feedback;
use App\Incomplete;
use Charts;
use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;
use App\PanelFeedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Log;

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

        $project = $id;

        return view('agents.surveys', compact('surveys', 'project'));
    }
    public function thirdpage(Request $request)
    {

        $survey =  $request->survey;
        // echo $request;

        $surv = Survey::where('slug', $survey)->first();
        // echo $surv;
        $daysbetweeninterviews = $surv->days_between_interview;

        // echo $daysbetweeninterviews;

        $respondent = $this->fetchuser($request->project, $daysbetweeninterviews);
        // echo $respondent;
        if ($respondent == "norespondents") {
            // echo $respondent;
            return redirect()->back()->with(['message' => "No Respondents have been assigned to the Project Yet. Please ask the Project Manager to do so.", 'alert-type' => 'error']);
        } else {

            // echo $respondent;

            // echo $lid;
            // echo  $lid->diffInDays($todaysdate);

            // echo $todaysdate;

            $feedbacks = PanelFeedback::all();
            $project = $request->project;

            $feedback = Feedback::where('respondent_id', $respondent[0]->id)->latest()->take(5)->get();

            $lastinterviewdate = Interview::where('respondent', $respondent[0]->id)->latest()->first();
            if ($lastinterviewdate == null) {
                $lastinterviewdate =  'no interview yet';
            } else {
                $lastinterviewdate = $lastinterviewdate->date;
            }
            // var_dump($lastinterviewdate);
            // echo $respondent;

            return view('agents.thirdpage', compact('survey', 'respondent', 'project', 'feedback', 'feedbacks', 'lastinterviewdate'));
        }
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

        $interviewchart = Charts::database($interviews, 'line', 'chartjs')
            ->title("Your interviews per day")
            ->elementLabel("No of Interviews")
            ->dimensions(600, 500)

            ->groupByDay();
        return view('agents.overview', compact('interviewchart', 'interviews'));
    }

    // add feedback to a client
    public function addfeedback(Request $request)
    {

        DB::table('feedback')->insert(['respondent_id' => $request->input('respondent'), 'agent' => Auth::user()->id, 'feedback' => $request->input('feedback'), 'other' => $request->input('other')]);

        $respondent = Respondent::where('id', $request->input('respondent'))->get();
        $survey = $request->input('survey');
        $feedback = Feedback::where('respondent_id', $respondent[0]->id)->latest()->take(5)->get();
        $feedbacks = PanelFeedback::all();
        $project = $request->project;

        $request->survey = $survey;


        // return response()->json(["message" => "successful"]);

        // return view('agents.thirdpage', compact('respondent', 'survey', 'project', 'feedback', 'feedbacks'));
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


    public function getnewuser($project, $survey)
    {

        $survey =  $survey;
        // echo $request;

        $surv = Survey::where('slug', $survey)->first();
        // echo $surv;
        $daysbetweeninterviews = $surv->days_between_interview;

        // echo $daysbetweeninterviews;

        $respondent = $this->fetchuser($project, $daysbetweeninterviews);

        $feedback = Feedback::where('respondent_id', $respondent[0]->id)->latest()->take(5)->get();

        $lint = Interview::where('respondent',  $respondent[0]->id)->latest()->get();

        // echo $lint;

        return response()->json([$respondent, $feedback, $lint]);
    }

    public function checkdate(Request $request)
    {

        if (Interview::where('respondent', '=', $request->respondent)->where('date', $request->date)->exists()) {
            return response()->json(['exists' =>  true]);
        } else {
            return response()->json(['exists' =>  false]);
        }
    }
    public function fetchuser($project, $daysbetweeninterviews)
    {
        $respondents = Respondent::where('project', $project)->get();
        if ($respondents->isEmpty()) {
            return "norespondents";
        } else {
            $respondent = Respondent::where('project', $project)->get()->random(1);
            $lid = Interview::where('respondent', $respondent[0]->id)->latest()->first();
            $todaysdate = Carbon::now();
            // echo ($respondent);
            if ($lid == null) {
                $respondent = $respondent;
                return $respondent;
            } else {
                $diff =  $todaysdate->diffInDays($lid->date);

                if ($diff < $daysbetweeninterviews) {

                    return  $this->fetchuser($project, $daysbetweeninterviews);
                } else {
                    return $respondent;
                }
            }
        }
    }
    public function refreshuser($id)
    {
        $respondent = Respondent::find($id);
        $feedback = Feedback::where('respondent_id', $respondent->id)->latest()->take(5)->get();
        $lint = Interview::where('respondent',  $respondent->id)->latest()->get();
        return response()->json([$respondent, $feedback, $lint]);
    }

    public function save_incomplete(Request $request)
    {
        $incomplete =  new Incomplete();
        $agent = (object) $request->input('agent');
        $respondent = $request->input('respondent');
        // echo $respondent;
        $incomplete->agent = $agent->agent;
        $incomplete->survey = $request->input('survey');
        $incomplete->respondent = $respondent;
        $incomplete->json = json_encode($request->input('json'));

        if ($incomplete->save()) {
            return response()->json(['message' => 'Success', 'data' => $incomplete]);
        } else {
            return response()->json(['message' => 'error occured']);
        }
    }
    public function make_call(Request $request)
    {

        // Set your app credentials
        $username = "TIFACommodityPrices";
        $apiKey   = "275afd71fe6ed4c404771065d8b3eab9ed4dde0307c79765ba83db28a92c9c75";

        // Initialize the SDK
        $AT       = new AfricasTalking($username, $apiKey);

        // Get the voice service
        $voice    = $AT->voice();

        // Set your Africa's Talking phone number in international format
        $from     = "+254711082023";

        // Set the numbers you want to call to in a comma-separated list
        $to       = "+254715686316";

        try {
            // Make the call
            $results = $voice->call([
                'from' => $from,
                'to'   => $to,
                'clientRequestId' => strval($request->respondent)
            ]);
            echo $request->respondent;

            print_r($results);
            $call = new Call();
            $call->respondent = $request->respondent;
            $call->session_id = $results['data']->entries[0]->sessionId;
            $call->status = $results['data']->entries[0]->status;
            $call->agent = Auth::user()->id;

            if ($call->save()) {
                # code...
                echo "saved";
            } else {
                echo "not saved";
            }

            Log::info($results);

            print_r($results);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function calls_callback(Request $request)
    {
        Log::warning($request);
        $sessionId = $request->sessionId;

        // $call = Call::where('session_id',  $sessionId);

        // Log::info($call);

        // Check to see whether this call is active
        $isActive  = $request->isActive;

        if ($isActive == 1) {

            // Forward by dialing customer service numbers and record the conversation

            Call::where('session_id',  $sessionId)->update('status', 'Active');

            // Compose the response
            $response  = '<?xml version="1.0" encoding="UTF-8"?>';
            $response .= '<Response>';
            $response .= '<Dial record="true" sequential="true" phoneNumbers="+254728554902" ringbackTone="http://cati.tifaresearch.com/callbackringtone.mp3" />';
            $response .= '</Response>';

            // Print the response onto the page so that our gateway can read it
            header('Content-type: application/xml');
            echo $response;
        } else {
            Call::where('session_id',  $sessionId)->update('status', 'Ended');
            // Read in call details (duration, cost). This flag is set once the call is completed.
            // Note that the gateway does not expect a response in thie case

            $duration     = $_POST['durationInSeconds'];
            $currencyCode = $_POST['currencyCode'];
            $amount       = $_POST['amount'];

            // Be sure to read in the URL of the recorded conversation
            $recording    = $_POST['recordingUrl'];
            Log::info($recording);
            Call::where('session_id',  $sessionId)->update('recording_link', $request->recordingUrl);
            // You can then store this information in the database for your records
        }
    }
    public function calls_events(Request $request)
    {
        Log::warning($request);
    }
}
