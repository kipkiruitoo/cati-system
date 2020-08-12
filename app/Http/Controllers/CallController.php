<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// GuzzleH

class CallController extends Controller
{
    //

    public function index()
    {
        return view('calls.dialer');
    }

    public function capability(Request $request)
    {
        $username = "lexeme";
        $apiKey   = "18a0ab0cd1e6a6d16cd38ed464b7839a2ffef87431077a60c1b573ef644d0ca5";
        // dd(Auth::user());
        // $token = null;
        $url = 'https://webrtc.africastalking.com/capability-token/request';
        // $data
        $client = new \GuzzleHttp\Client();

        $mybody = [
            'username' => $username,
            'phoneNumber' => '+254711082144',
            "clientName" => str_replace(" ", "", Auth::user()->name),
            "incoming" => 'true',
            "outgoing" => 'true',
            "expire" => '7200s'
        ];
        // array_push($mybody, $username);
        // array_push($mybody, "+254711082144");
        $headers = [

            'Accept'     => 'application/json',
            'Content-Type'      => 'application/json',
            'APIKEY' =>  $apiKey

        ];




        // dd($mybody);
        $response = $client->request('POST', $url, [

            \GuzzleHttp\RequestOptions::JSON => $mybody,
            'headers' => $headers


        ]);

        $body = $response->getBody();



        // dd($body);
        $stringBody = (string) $body;
        // dd($stringBody);

        return $stringBody;
        // $client->send(request);

        // $mybody['username'] = $username;
        // $mybody['phoneNumber']
    }


    public function recordings(Request $request)
    { {
            if (request()->ajax()) {
                if (!empty($request->filter_phone)) {
                    $data = DB::table('web_calls')
                        ->select('agent', 'phonecalled', 'recording_link', 'created_at')
                        ->where('agent', $request->filter_agent)
                        ->where('phonecalled', $request->filter_phone)
                        ->get();
                } else {
                    $data = DB::table('web_calls')
                        ->select('agent', 'phonecalled', 'recording_link', 'created_at')
                        ->get();
                }
                return datatables()->of($data)->startsWithSearch()->smart(true)->make(true);
            }
            $country_name = DB::table('web_calls')
                ->select('created_at')
                ->groupBy('created_at')
                ->orderBy('created_at', 'ASC')
                ->get();
            return view('calls.recordings', compact('country_name'));
        }
        // return view('calls.recordings');
    }
}
