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

Route::group(['middleware' => ['cors', 'json.resp']], function () {
    Route::post('/login', 'App\Http\Controllers\API\AuthController@login')->name('login.api');
    Route::post('/register', 'App\Http\Controllers\API\AuthController@register')->name('register.api');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'App\Http\Controllers\API\AuthController@logout')->name('logout.api');
    Route::get('/userdata', 'App\Http\Controllers\API\UsersController@getUserData')->name('userdata.api');
    Route::post('/updateUserData', 'App\Http\Controllers\API\UsersController@updateUserData')->name('update_userdata.api');
    Route::delete('/deleteUser', 'App\Http\Controllers\API\UsersController@deleteUser')->name('delete.api');
    Route::get('/users', 'App\Http\Controllers\API\UsersController@getUsers')->name('users.api');

    Route::post('/newTask', 'App\Http\Controllers\API\TasksController@createTask');
    Route::post('/editTask', 'App\Http\Controllers\API\TasksController@updateTask');
    Route::patch('/changeTaskStatus', 'App\Http\Controllers\API\TasksController@changeTaskStatus');
    Route::delete('/deleteTask', 'App\Http\Controllers\API\TasksController@deleteTask');
    Route::get('/tasks', 'App\Http\Controllers\API\TasksController@getTasks');
    Route::patch('/changeTaskUser', 'App\Http\Controllers\API\TasksController@changeTaskUser');
});
