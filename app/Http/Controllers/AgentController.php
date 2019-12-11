<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Projects;

class AgentController extends Controller
{
    
    public function firstpage(){
        return view('agents.index');
    }
}
