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

Route::group(['middleware' => 'auth'], function() {
	Route::get('/', 'CyclingController@showUserInformationPage');
	Route::get('/get-updates', 'CyclingController@getUpdates');

	Route::group(['prefix' => 'tests'], function() {
		Route::get('sending-data', 'TestingCyclingController@testShowTestingSendingDataPage');
		Route::get('get-updates', 'TestingCyclingController@testGetUpdates');
		Route::get('send-data', 'TestingCyclingController@testShowTestSendData');
	});
});
Route::post('/session-stop', 'CyclingController@stopSession');

Route::post('/tests/sending-data', 'TestingCyclingController@testPedalling');

Route::post('/cycling', 'CyclingController@pedalling');

Route::auth();
