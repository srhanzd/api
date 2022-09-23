<?php

use App\Http\Controllers\passportAuthController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//routes/api.php
//Route::post('register',[passportAuthController::class,'registerUserExample']);
//Route::post('login',[passportAuthController::class,'loginUserExample']);
////add this middleware to ensure that every request is authenticated
//Route::middleware('auth:api')->group(function(){
//    Route::get('user', [passportAuthController::class,'authenticatedUserDetails']);
//});
Route::post('user/login',[passportAuthController::class, 'userLogin'])->name('login');
Route::post('user/register',[passportAuthController::class, 'userregister'])->name('userregister');

Route::group( ['prefix' => 'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
    // authenticated staff routes here
   // Route::get('dashboard',[passportAuthController::class, 'userDashboard']);
    Route::post('logout',[passportAuthController::class, 'userLogout']);


});
