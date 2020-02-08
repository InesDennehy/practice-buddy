<?php

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

use App\Http\Controllers\CategoriesController;
use GuzzleHttp\Middleware;

Route::get('/', function () {
    if(Auth::user())
        return redirect('/home');
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/categories', 'CategoriesController@index')->middleware('auth');
Route::post('/categories', 'CategoriesController@store')->middleware('auth');
Route::delete('/categories/{id}', 'CategoriesController@delete')->middleware('auth');

Route::post('/pieces', 'PiecesController@store')->middleware('auth');
Route::get('/pieces/{id}', 'PiecesController@index')->middleware('auth');
Route::delete('/pieces/{id}', 'PiecesController@delete')->middleware('auth');

Route::post('/sessions', 'SessionsController@store')->middleware('auth');
Route::delete('/sessions/{pieceid}', 'SessionsController@delete')->middleware('auth');
