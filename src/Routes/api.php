<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'api'/*, 'middleware' => ['web', 'auth']*/], function () {
    Route::post('polls', 'SergioBogatsky\TelegramPollsWithoutGroup\Controllers\PollsController@index');
    Route::post('polls/store', 'SergioBogatsky\TelegramPollsWithoutGroup\Controllers\PollsController@store');
    Route::post('polls/show/{id}', 'SergioBogatsky\TelegramPollsWithoutGroup\Controllers\PollsController@show');
    Route::post('polls/test', 'SergioBogatsky\TelegramPollsWithoutGroup\Controllers\PollsController@test');
});
