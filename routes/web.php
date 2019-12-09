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

Route::get('/script', 'ScripterController@index');
Route::get('/script/surveys/{id}', 'ScripterController@surveys')->name('scriptersurveys');

Route::get('/surveys/create/{id}', 'SurveyController@create')->name('createsurvey');
