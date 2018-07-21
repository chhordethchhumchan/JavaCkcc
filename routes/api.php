<?php

use Illuminate\Http\Request;

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

Route::post('login', 'API\UserController@login')->name('login');
Route::post('register', 'API\UserController@register');


Route::get('text', 'API\TextController@index');
Route::get('video', 'API\VideoController@index');
Route::get('picture', 'API\PictureController@index');

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('logout', 'API\UserController@logoutApi')->name('logout');
	Route::post('update/{user_id}', 'API\UserController@updateprofile');

    Route::get('details', 'API\UserController@details');
	Route::get('getdata', 'API\UserController@getdata');

	
	Route::post('text/store', 'API\TextController@store');

	
	Route::post('picture/store', 'API\PictureController@store');

	Route::post('ad/store', 'API\AdController@store');

	Route::get('diabeterecord', 'API\DiabeteRecordController@index');
	Route::post('diabeterecord/store', 'API\DiabeteRecordController@store');
	Route::post('diabeterecord/update/{id}', 'API\DiabeteRecordController@update');

	
	Route::post('video/store', 'API\VideoController@store');
	Route::get('video/create', 'API\VideoController@create');


	/* Role & Permission Attach */
	Route::get('/user/{user_id}/roles', 'ApiPermission\HomeController@getUserRole');
	Route::get('/user/{user_id}/roles/{role_name}', 'ApiPermission\HomeController@attachUserRole');
	Route::post('/role/permission', 'ApiPermission\HomeController@attachPermission');
	Route::get('/role/permissions', 'ApiPermission\HomeController@getPermission');
	Route::get('/user_permission/{user_id}/{permission}', 'ApiPermission\HomeController@checkPermission');

	Route::get('itemCRUD2',['as'=>'itemCRUD2.index','uses'=>'ItemCRUD2Controller@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);

});

