<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Route::get('/draft/join', 'DraftJoinController@create');
Route::post('/draft/join', 'DraftJoinController@store');

Route::get('/draft/create', 'DraftController@create');
Route::post('/draft/store', 'DraftController@store');

Route::get('/drafts/{draft:code}', 'DraftController@show');
Route::delete('/drafts/{draft}/leave', 'DraftController@delete');
Route::put('/drafts/{draft}/start', 'DraftController@update');
Route::post('/draft/{draft}/pick', 'PickController@store');
