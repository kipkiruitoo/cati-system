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
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::resource('/projects', 'ProjectController');

Route::resource('/surveys', 'SurveyController');

Route::get('/script', 'ScripterController@index')->name('script');
Route::get('/script/surveys/{id}', 'ScripterController@surveys')->name('scriptersurveys');

Route::get('/surveys/create/{id}', 'SurveyController@create')->name('createsurvey');
Route::get('/scripter/create/{id}', 'ScripterController@create')->name('screatesurveyform');
Route::post('/scripter/post', 'ScripterController@createsurvey')->name('screatesurvey');

Route::put('/changestatus/{id}', 'ScripterController@changestatus')->name('changestatus');
Route::put('/assignclients/{id}', 'ProjectController@assignclient')->name('assignclients');
Route::put('/assignrespondents/{id}', 'ProjectController@assignrespondents')->name('assignrespondents');


Route::get('/respondents/export', function(){

     return Excel::download(new RespondentExport, 'respondents.xlsx');
});
Route::post('/respondents/import', 'ProjectController@importrespondents')->name('uploadrespondents');
Route::get('/users/export', function(){

     return Excel::download(new UsersExport, 'users.xlsx');
});



Route::get('/agent', 'AgentController@firstpage')->name('agent');

Route::get('/agent/project/{id}', 'AgentController@secondpage')->name('agentchoseproject');
Route::post('/agent/project/survey', 'AgentController@thirdpage')->name('agentthirdpage');


Route::get('/supervisor', 'ProjectController@supervisorview')->name('supervisor');

Route::get('/projectagents/{id}', 'ProjectController@projectagents')->name('projectagents');

Route::post('/addagents/{id}', 'ProjectController@addagents')->name('addagents');


Route::post('/removeagents/{id}', 'ProjectController@removeagents')->name('removeagents');




Route::get('/agent/interviews', 'AgentController@interviews')->name('pinterviews');

Route::get('/agent/overview', 'AgentController@overview')->name('poverview');
Route::post('add-feedback', 'AgentController@addfeedback');


// qc urls

Route::get('/qc', 'QCController@index')->name('qc');
Route::post('/qc', 'QCController@interviews');