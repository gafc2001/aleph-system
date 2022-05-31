<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\V1\AttendanceController;
use App\Http\Controllers\V1\AuthController;


Route::middleware('auth:api')->group(function (){
    Route::apiResource('attendances',AttendanceController::class);
    Route::post('upload/excel',[AttendanceController::class,'upload']);
});

//Security
Route::prefix('auth')->group(function(){
    Route::post('revoke',[AuthController::class,'revoke']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('signup',[AuthController::class,'signup']);
    Route::get('user',[AuthController::class,'user']);
});