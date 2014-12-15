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

Route::get('/', 'EventController@index');
Route::get('/officialevent', 'EventController@officialEventList');
Route::get('/memberevent', 'EventController@memberEventList');
Route::get('/creatememberevent', 'EventController@createMemberEvent');
Route::post('/creatememberevent', 'EventController@addMemberEvent');
Route::get('/wishlist', 'EventController@myevent');
Route::post('/join', 'EventController@join');

Route::get('/officialevent/position/{id}', 'EventController@getOEPoint');
Route::get('/memberevent/position/{id}', 'EventController@getMEPoint');

Route::get('/signin', 'AuthenController@signIn');
Route::get('/signin/callback', 'AuthenController@signInCallback');
Route::get('/logout', 'AuthenController@logOut');

Route::get('/tradingzone', 'TradeController@index');


Route::get('/mobile/officialevent', 'MobileController@getAllOfficialEvent');
Route::get('/mobile/officialevent/{id}', 'MobileController@getOfficialEvent');
