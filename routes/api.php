<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\V1\AttendanceController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\PermissionController;


//admin
Route::middleware(['auth:api',"scope:admin-access"])->group(function (){
    Route::apiResource('attendances',AttendanceController::class);
    Route::post('upload/excel',[AttendanceController::class,'upload']);
    
});

Route::apiResource('permissions',PermissionController::class)->except("destroy");
//employee
Route::middleware(['auth:api',"scope:employee-access"])->group(function (){
    Route::get("users/permissions",[PermissionController::class,'listPermissionsByUser']);
});

//Security
Route::prefix('auth')->group(function(){
    Route::post('revoke',[AuthController::class,'revoke']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('signup',[AuthController::class,'signup']);
    Route::get('user',[AuthController::class,'user']);
});