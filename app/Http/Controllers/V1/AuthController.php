<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\SignUpRequest;
use App\Http\Resources\V1\Auth\AuthResource;
use App\Http\Resources\V1\Auth\AuthUserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware("auth:api")->only(['revoke','user']);
    }
    public function login(LoginRequest $request){
        if(Auth::attempt($request->all())){
            $user = User::where("email",$request->email)->first();
            return new AuthResource($user);
        }
        return response()->json([
            "message" => "Invalid credentials",
        ],Response::HTTP_UNAUTHORIZED);
        
    }
    public function signup(SignUpRequest $request){
        $user = User::create($request->all());
        return response()->json([
            "message" => "Register succesfully",
            "user_email" => $user->email,
        ],Response::HTTP_CREATED);
    }
    public function revoke(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            "message" => "Revoke token access succesfully",
        ]);
    }
    public function user(Request $request){
        return new AuthUserResource($request->user());
    }
}
