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

Route::get('/draft/join', 'DraftController@index');
Route::post('/draft/join', 'DraftController@store');

Route::get('/drafts/{draft}', 'DraftController@show');
Route::post('/draft/{draft}/pick', 'PickController@store');
