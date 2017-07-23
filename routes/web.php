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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::delete('words/mass_destroy', 'WordsController@massDestroy')->name('words.mass_destroy');
    Route::resource('words', 'WordsController');
	Route::get('importExport', [
		'as' => 'words.importExport',
		'uses' => 'WordsController@importExport'
	]);
	Route::get('downloadExcel/{type}', [
		'as' => 'words.downloadExcel',
		'uses' => 'WordsController@downloadExcel'
	]);
	Route::post('importExcel', [
		'as' => 'words.importExcel',
		'uses' => 'WordsController@importExcel'
	]);
});
