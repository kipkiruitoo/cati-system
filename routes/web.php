<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Exports\RespondentExport;
use App\Exports\UsersExport;
use App\Exports\FeedbackExport;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProjectController;
use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Routing\Route;
// use TCG\Voyager\Voyager;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::resource('/projects', 'ProjectController')->middleware('auth');

Route::resource('/surveys', 'SurveyController')->middleware('auth');

Route::get('/script', 'ScripterController@index')->name('script')->middleware('auth');
Route::get('/script/surveys/{id}', 'ScripterController@surveys')->name('scriptersurveys')->middleware('auth');

Route::get('/surveys/create/{id}', 'SurveyController@create')->name('createsurvey')->middleware('auth');
Route::get('/scripter/create/{id}', 'ScripterController@create')->name('screatesurveyform')->middleware('auth');
Route::post('/scripter/post', 'ScripterController@createsurvey')->name('screatesurvey')->middleware('auth');

Route::put('/changestatus/{id}', 'ScripterController@changestatus')->name('changestatus')->middleware('auth');
Route::put('/assignclients/{id}', 'ProjectController@assignclient')->name('assignclients')->middleware('auth');
Route::put('/assignrespondents/{id}', 'ProjectController@assignrespondents')->name('assignrespondents')->middleware('auth');


Route::get('/respondents/export', function () {

    return Excel::download(new RespondentExport, 'respondents.xlsx');
})->middleware('auth');
Route::post('/respondents/import', 'ProjectController@importrespondents')->name('uploadrespondents')->middleware('auth');
Route::get('/users/export', function () {

    return Excel::download(new UsersExport, 'users.xlsx');
})->middleware('auth');



Route::get('/agent', 'AgentController@firstpage')->name('agent')->middleware('auth');

Route::get('/agent/project/{id}', 'AgentController@secondpage')->name('agentchoseproject')->middleware('auth');
Route::post('/agent/project/survey', 'AgentController@thirdpage')->name('agentthirdpage')->middleware('auth');
// Route::get('/agent/project/survey', 'AgentController@thirdpage')->name('agentthirdpage');


Route::get('/supervisor', 'ProjectController@supervisorview')->name('supervisor')->middleware('auth');

Route::get('/supervisor/projectagents/{id}', 'ProjectController@projectagents')->name('projectagents')->middleware('auth');

Route::post('/addagents/{id}', 'ProjectController@addagents')->name('addagents')->middleware('auth');
Route::get('/supervisor/reports', 'ProjectController@reports')->name('supervisorreports')->middleware('auth');


Route::post('/removeagents/{id}', 'ProjectController@removeagents')->name('removeagents')->middleware('auth');




Route::get('/agent/interviews', 'AgentController@interviews')->name('pinterviews')->middleware('auth');

Route::get('/agent/overview', 'AgentController@overview')->name('poverview')->middleware('auth');
Route::post('add-feedback', 'AgentController@addfeedback');
Route::get('/get-user/{project}/{survey}', 'AgentController@getnewuser');
Route::get('/refresh-user/{id}', 'AgentController@refreshuser');



Route::post('api/check-date', 'AgentController@checkdate');


// qc urls

Route::get('/qc', 'QCController@index')->name('qc')->middleware('auth');
Route::post('/qc', 'QCController@interviews')->middleware('auth');
Route::get('/qc/{id}/results/{interview}', 'QCController@results')->middleware('auth');
Route::get('/qc/project/surveys/{id}', 'QCController@surveys')->name('qcsurveys')->middleware('auth');

Route::post('/saveqcresults', 'QCController@saveqcresults');

Route::get('/qc/reports', 'QCController@selectproject')->name('qcreport');
Route::post('/qc/reports', 'QCController@reports')->name('projectselected');

Route::post('/getresults', 'SurveyController@getresults')->name('getresults');

Route::post('/api/incomplete', 'AgentController@save_incomplete')->name('incomplete');


Route::post('/feedbackexports', 'SurveyController@exportfeedback')->name('feedbackexports');



Route::get('/getexcel', function () {
    $file = Storage::disk('public')->get('format.xlsx');

    return (new Response($file, 200))
        ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
})->name('getexcel');


Route::get('/analytics/{id}/view/{slug}', 'AnalyticsController@index')->name('analytics')->middleware('auth');


Route::post('/agent/call', 'AgentController@make_call')->name('makecall');
Route::post('/calls/callback', 'AgentController@calls_callback');
Route::post('/calls/events', 'AgentController@calls_events');


Route::get('/project/credit', 'ProjectController@show_credits')->name('showcredits')->middleware('auth');


Route::get('walletballance', 'ProjectController@get_wallet_balance')->name('walletbalance');


Route::get('/project/{id}/billing', 'ProjectController@billing')->name('billing');

Route::get('/project/{id}/billing/calls', 'ProjectController@call_details_excel')->name('callsexcel');


Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});


Route::get('/survey/structure/{survey}', 'SurveyController@getSurveyStrucrure')->name('surveystructure');

Route::get('/survey/tool/{survey}', 'SurveyController@getSurveyTool')->name('surveytool');


Route::get('manage/respondents/{project}', 'RespondentsController@index')->name('respondents.index');
Route::post('manage/respondents', 'RespondentsController@runquery')->name('respondents.query');
// respondentsquery


Route::get('download/recordings', 'FilesController@downloadfiles');


Route::post('pauseinterview', 'AgentController@pauseinterview')->name('pauseinterview');


Route::post('reschedule', 'AgentController@reschedule')->name('reschedule');
