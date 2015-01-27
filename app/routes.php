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

Route::get('/talent/', function()
{
	$talent = Talent::all();
	$talent->each(function($talent)
    {
        echo "<a href='http://178.62.82.197/networkscraper/public/index.php/talent/$talent->talent_id/matches'>$talent->displayName</a><br/>";
    });
});

Route::get('/talent/{talentId}/matches', function($talentId)
{
	//$talent = Talent::where('talent_id', '=', $talentId)->first();

	$talent = Talent::where('talent_id', '=', $talentId)->first();
	$matches = $talent->getMatchStartMilestones();

	$matches = $matches->sortBy(function($matches)
	{
	    return $matches->episode->air_date;
	});

	$matches->each(function($match)
    {
    	echo $match->episode->headline . "<br/>";
    	echo "<a href='http://network.wwe.com/video/v{$match->episode->media_playback_id}/milestone/$match->milestone_id'>$match->blurb</a><br/><br/>";
    });
});

Route::get('/show/', function()
{
	$shows = Show::all();

	$shows->each(function($show)
    {
        echo "$show->title<br/>";
    });
	
});

Route::get('/episode/', function()
{
	$episodes = Episode::all();

	$episodes = $episodes->sortBy(function($episodes)
	{
	    return $episodes->air_date;
	});
	$episodes->each(function($episodes)
    {
    	echo $episodes->headline . "<br/>";
    	echo $episodes->bigblurb . "<br/><br/>";
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
