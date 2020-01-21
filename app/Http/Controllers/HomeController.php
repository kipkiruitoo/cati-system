<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role_id == 5) {

            return redirect()->route('supervisor');

        }else if(Auth::user()->role_id == 2 ){
            return redirect()->route('agent');
        }else if(Auth::user()->role_id == 4){
            return redirect()->route('script');

        }else if(Auth::user()->role_id == 6){
            return redirect()->route('qc');
        }
        else{
             return redirect()->route('voyager.dashboard');
        }

    }
}
