<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/talent/{talentId}', function($talentId)
{
	//$talent = Talent::where('talent_id', '=', $talentId)->first();

	$talent = Talent::where('talent_id', '=', $talentId)->with('milestones')->first();

	//dd($talent);
dd(DB::getQueryLog());


    return 'talent '.$talentId;
});

