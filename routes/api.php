<?php

use Illuminate\Http\Request;

use App\Word;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
* Takes params
*/

Route::get('/words/get-all', function(Request $_request) {
	$request = $_request->toArray();

	if(!empty($request['order']) || !empty($request['order_by'])) {
		if(empty($request['order']) || empty($request['order_by'])) {
			return response([
				'status' => 'error',
				'message' => 'Both order & order_by have to be given!'
			]);
		}
	}

	$words = Word::limit(!empty($request['limit']) ? $request['limit'] : null)
				->offset(!empty($request['offset']) ? $request['offset'] : null)
				->orderBy(
					!empty($request['order_by']) ? $request['order_by'] : null,
					!empty($request['order']) ? $request['order'] : null
				)
				->get(); // Didn't know how to chain them but this way...

	$data = [
		'status' => 'success',
		'data' => ['words' => $words]
	];

	return response($data);
});

Route::get('/words/get-word/{word}', function($word) {
	$data = [
		'status' => 'success',
		'data' => ['word' => Word::where('word', $word)->get(['word', 'meaning','created_at', 'updated_at'])]
	];
	return response($data);
});