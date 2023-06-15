<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/add-admin', [UserController::class, 'add_admin']); //admin ekler
Route::post('/add-user', [UserController::class, 'add_user']);  //user ekler

Route::middleware('auth.token')->group(function () {
    Route::get('/user-info', [UserController::class, 'get_user_info']); // token dan user bilgisini yakalar
    Route::post('/add-task', [TaskController::class , 'add_task']); //task ekler
    Route::post('/update-task', [TaskController::class , 'update_task']); //task gunceller
    Route::post('/delete-task' , [TaskController::class ,'delete_task']);
});
