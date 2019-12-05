<?php

namespace App\Http\Controllers;

use App\Projects;
use App\User;
use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;

use Illuminate\Support\Facades\DB;
use TCG\Voyager\Facades\Voyager\Role;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $projects = Projects::all();


        return view('projects.index')->withProjects($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pms = DB::table('roles')->join('user_roles', 'user_roles.role_id', '=', 'roles.id')->join('users','users.id', '=', 'user_roles.user_id' )->where('roles.name', 'Project Manager')->get();
        return view('projects.create', compact('pms'));

        // print_r($pms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proj =  new Projects;

        $proj->name =  $request->name;
        $proj->start_date =  $request->sdate;
        $proj->slug = str_slug($request->name); 
        $proj->end_date =  $request->edate;
        $proj->pm =  $request->pm;


        if ($proj->save()) {
           
            
        $projects = Projects::all();


        return view('projects.index')->withProjects($projects);
        }else{
            $pms = DB::table('roles')->join('user_roles', 'user_roles.role_id', '=', 'roles.id')->join('users','users.id', '=', 'user_roles.user_id' )->where('roles.name', 'Project Manager')->get();
            return view('projects.create', compact('pms'));

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Projects::findOrFail($id)->first();
        $surveys = Survey::where('project', $id)->get();


        return view('projects.show', compact('surveys', 'id'))->withProject($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $project = Projects::where('id', $id)->first();

       $pms = DB::table('roles')->join('user_roles', 'user_roles.role_id', '=', 'roles.id')->join('users','users.id', '=', 'user_roles.user_id' )->where('roles.name', 'Project Manager')->get();

        return view('projects.edit', compact('pms'))->withProject($project);
    // print_r($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $proj =  Projects::findOrFail($id);

        $proj->name =  $request->name;
        $proj->start_date =  $request->sdate;
        $proj->slug = str_slug($request->name); 
        $proj->end_date =  $request->edate;
        $proj->pm =  $request->pm;


        if ($proj->save()) {
           
            
        $projects = Projects::all();


        return redirect()->route('projects.index')->withProjects($projects);
//  echo "worked";


        }else{
            $project = $proj;
            $pms = DB::table('roles')->join('user_roles', 'user_roles.role_id', '=', 'roles.id')->join('users','users.id', '=', 'user_roles.user_id' )->where('roles.name', 'Project Manager')->get();
            return redirect()->route('projects.edit', $proj->id, compact('pms', 'project'));

            // echo "an error occured";

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pj = Projects::find($id);

        if ($pj->delete()) {
               
        $projects = Projects::all();


        return redirect()->route('projects.index')->withProjects($projects);
        }else{

            echo('an error occured while deleting');
        }
    }
}
