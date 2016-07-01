<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Avanderbergh\Schoology\Facades\Schoology;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    Schoology::authorize();
    $realm_id = $request->get('realm_id');
    $result = Schoology::apiResult('sections/'.$realm_id.'/enrollments');
    $students = array();
    foreach ($result->enrollment as $enrollment)
    {
        if (!$enrollment->admin)
        {
            $students[] = $enrollment->name_display;
        }
    }
    $name = $students[rand(0,sizeof($students)-1)];
    return view('welcome')->with('name', $name)->with('realm_id', $realm_id);
});
