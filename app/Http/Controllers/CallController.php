<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CallController extends Controller
{
    //

    public function index()
    {
        return view('calls.dialer');
    }

    public function capability(Request $request)
    {
        $token = null;
        $url = 'https://webrtc.africastalking.com/capability-token/request';
        // $data
    }
}
