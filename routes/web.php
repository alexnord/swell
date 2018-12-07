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

// Route::get('/', 'HomeController@index')->name('home');
Route::get('/', function() {
	return redirect()->action(
	    'LocationController@index', ['location' => 'malibu-1st-point']
	);
})->name('home');

Route::get('locations/{location}', 'LocationController@index');

Route::middleware(['auth'])->group(function () {
    Route::get('/create', 'ReportController@create')->name('create');
	Route::get('/reports', 'ReportController@all')->name('all');
	Route::get('/report/{id}', 'ReportController@show')->name('show');
});

Auth::routes();

Route::prefix('api')->group(function () {
	Route::resource('reports', 'ReportController');
	Route::get('swell', 'SwellController@getSwellData');
});