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

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/polls', function () {
        return view('polls::polls.index');
    });
    Route::get('/polls/{any?}', function (){
        return view('polls::polls.index');
    })->where('any', '^(?!api\/)[\/\w\.-]*');
});
