<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\V1\AttendanceController;
use App\Http\Controllers\V1\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function (){
    Route::apiResource('attendances',AttendanceController::class);


    //Revoke access token
});

//Security
Route::post('revoke',[AuthController::class,'revoke']);
Route::post('login',[AuthController::class,'login']);
Route::post('signup',[AuthController::class,'signup']);