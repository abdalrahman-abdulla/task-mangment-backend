<?php

use Illuminate\Http\Request;
use App\Events\newTask;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::get('departments','AuthController@departments');
});


Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth:api','admin']
],function(){
        Route::apiResource('/task', 'TaskController');
        Route::apiResource('/department', 'DepartmentController');
        Route::get('task/{id}/requests','RequestController@index');

        Route::post('task/{id}/acceptrequest','RequestController@accept');
        Route::post('task/{id}/approverequest','TaskController@approve');
});

Route::group([
    'prefix' => 'user',
    'namespace' => 'User',
    'middleware' => ['auth:api']
], function ($router) {
    route::apiResource('/task', 'TaskController')->except([
        'store','destroy'
    ]);
    Route::post('task/{id}/comment','CommentController@store');
    Route::post('task/{id}/request','RequestController@store');
});
