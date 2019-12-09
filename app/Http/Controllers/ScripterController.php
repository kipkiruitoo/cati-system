<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use Auth;


use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;

class ScripterController extends Controller
{
 public function index()

    {
        $projects = Projects::where('sa', Auth::user()->id )->get();
        return view('scripters.index', compact('projects'));
    }

     public function surveys($id)

    {
        $project = Projects::findOrFail($id)->first();
        $surveys = Survey::where('project', $id)->get();


        return view('scripters.surveys', compact('surveys', 'id'))->withProject($project);
    }
}
