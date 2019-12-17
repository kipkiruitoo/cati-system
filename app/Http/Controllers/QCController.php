<?php

namespace App\Http\Controllers;
use App\Interview;

use Illuminate\Http\Request;

class QCController extends Controller
{
   public function index(){
       return view('qc.index');
   }
   public function interviews(Request $request){

    $date = $request->date;

    // echo $date;

    $interviews =  Interview::where('date', $date)->get();

    return view('qc.results', compact('interviews'));


   }
}
