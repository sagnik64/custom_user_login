<?php

use App\Http\Controllers\CustomAuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//to get data of all users
Route::get('data',[CustomAuthController::class,'getData']); 

// to get data of a particular user by ID
Route::get('data/{id}',[CustomAuthController::class,'getDataByID']); 

Route::post('save',[CustomAuthController::class,'postData']);

//to save user data in DB
Route::post('/register_user',[CustomAuthController::class, "registerUser"]); 

//to update user data by ID (ID is in Request)
Route::put('/update',[CustomAuthController::class, "editData"]);

//to validate login
Route::post('/login_user',[CustomAuthController::class, "loginUser"]);

//to search by starting letters of name
Route::get('/search/{name}',[CustomAuthController::class, "searchByName"]);

//to delete user data by ID
Route::delete('/delete/{id}',[CustomAuthController::class, "removeByID"]);