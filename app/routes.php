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

Route::get('/talent/{talentId}/matches', function($talentId)
{
	//$talent = Talent::where('talent_id', '=', $talentId)->first();

	$talent = Talent::where('talent_id', '=', $talentId)->first();
	$matches = $talent->getMatchStartMilestones();

	//dd(DB::getQueryLog());

	dd($matches);
});

Route::get('/show/', function()
{
	$shows = Show::all();

	$shows->each(function($show)
    {
        echo "$show->title<br/>";
    });
	
});

Route::get('/show/{showId}/', function($showId)
{
	$show = Show::where('show_name', '=', $showId)->first();
	$episodes = $show->episodes();

	$episodes = $episodes->get()->toArray();

	dd($episodes);		
});

Route::get('/category/', function()
{
	$categories = Category::all();
	$categories->each(function($category)
    {
        echo "$category->title<br/>";
    });});
