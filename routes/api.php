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

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');

Route::post('logout', 'Api\Auth\LoginController@logout')->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('tasks', 'Api\TasksController@index');

Route::middleware('auth:api')->post('tasks/completeTask/{task}', 'Api\TasksController@completeTask');
Route::middleware('auth:api')->post('tasks/activateTask/{task}', 'Api\TasksController@activateTask');
Route::middleware('auth:api')->post('tasks/getTask/{task}', 'Api\TasksController@getTask');
Route::middleware('auth:api')->post('tasks/saveTask', 'Api\TasksController@saveTask');
Route::middleware('auth:api')->delete('tasks/deleteTask/{task}', 'Api\TasksController@deleteTask');
Route::middleware('auth:api')->delete('tasks/clearCompletedTasks', 'Api\TasksController@clearCompletedTasks');
Route::middleware('auth:api')->delete('tasks/deleteAllTasks', 'Api\TasksController@deleteAllTasks');