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

Route::get('/{any}', 'SpaController@index')->where('any', '.*');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/create', 'ReportController@create')->name('create');

Auth::routes();

Route::prefix('api')->group(function () {
	Route::resource('reports', 'ReportController');
	Route::get('swell', 'SwellController@getSwellData');
});