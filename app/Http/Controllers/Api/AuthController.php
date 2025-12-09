<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Register(RegisterRequest $request)
    {
        $validated_date = $request->validated();
        
        $user = User::create($validated_date);

        if(!$user)
            return ApiResponse::sendResponse(505 ,' account fialed to create ' , []);

        $token = $user->createToken('loginToken')->plainTextToken;

        return ApiResponse::sendResponse(201 ,'Register successfully' , ['user' => new UserResource($user) , 'token' => $token]);
    }

    public function login(LoginRequest $request)
    {

        $validated_data = $request->validated();

        if(! Auth::attempt($validated_data))
        {
            return ApiResponse::sendResponse(401 , 'Password Is Not Valid' , []);
        }

        $user = Auth::user();
        
        $token = $user->createToken('loginToken')->plainTextToken;

        return ApiResponse::sendResponse(200  , 'Login Successfully' , ['user' => new UserResource($user) , 'token' => $token]); 
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::sendResponse(200 , 'Logout Successfully' , []);
    }
}
