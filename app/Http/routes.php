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

Route::get('/', function () {
    return view('welcome');
});
//syntax
Route::get('/api-get-syntax', 'SyntaxController@getAll');
Route::post('/api-create-syntax', 'SyntaxController@createSyntax');
Route::post('/api-delete-syntax', 'SyntaxController@deleteItem');
Route::post('/api-update-syntax', 'SyntaxController@updateItem');
Route::post('/api-get-syntax-by-id', 'SyntaxController@getById');
//action type
Route::get('/api-get-action-type', 'ActiontypeController@getAll');
Route::post('/api-create-action-type', 'ActiontypeController@createActionType');
Route::post('/api-delete-action-type', 'ActiontypeController@deleteItem');
Route::post('/api-update-action-type', 'ActiontypeController@updateItem');
//Route::get('/api-get-result-resource', 'HomeController@getNumberResultEveryDay');

//home
Route::get('api-get-result-resource/{pubDate}', 'HomeController@getItem');
Route::post('/api-insert-item-kq', 'HomeController@createKq');

Route::get('/test', 'HomeController@test');
Route::post('/api-get-calculator-process', 'CalculatorController@index');

//Player Controller
Route::get('/api-get-player', 'PlayerController@getAll');
Route::get('api-get-cash-out-by-pid/{playerId}', 'PlayerController@getCashOutByPlayerId');
Route::post('/api-modal-get-cash-out-post-id', 'PlayerController@modalGetCashOutPostId');
Route::post('/api-modal-update-cash-out', 'PlayerController@updateCashOut');
Route::post('/api-get-player-by-id', 'PlayerController@getById');
Route::post('/api-create-cash-out', 'PlayerController@createCashOut');
Route::post('/api-create-player', 'PlayerController@createPlayer');
Route::post('/api-delete-player', 'PlayerController@deleteItem');
Route::post('/api-update-player', 'PlayerController@updateItem');


Route::get('test3', 'HomeController@test3');
