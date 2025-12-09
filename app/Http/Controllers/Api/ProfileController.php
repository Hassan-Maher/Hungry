<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if(!$user)
            return ApiResponse::sendResponse(404 , 'User Not Found' , [] );

        return ApiResponse::sendResponse(200 , 'Profile Retreived successfully' , new UserResource($user));
    }

    public function update(ProfileRequest $request)
    {
        $validated_data  = $request->validated();

        $user = $request->user();

        if(!$user)
            return ApiResponse::sendResponse(404 , 'User Not Found' , []);

        $record = $user->update($validated_data);

        if(!$record)
            return ApiResponse::sendResponse(505 , 'Failed To Update Profile' , []);

        return ApiResponse::sendResponse(200 , 'Profile Updated Successfully' , new UserResource($user));
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'                  => ['required' , 'string' , 'current_password'],
            'new_password'              => ['required' , 'string' , 'min:8'],
            'new_password_confirmation' => ['required' , 'string' , 'min:8'],
        ], [], []);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'verify Validation Errors', $validator->messages()->all());
        }

        $user = $request->user();
        // if(!Hash::check($request->password , $user->password))
        //     return ApiResponse::sendResponse(403 , 'Password Not Valid' , []);

        $record = $user->update(['password' => $request->new_password]);

        if(!$record)
            return ApiResponse::sendResponse(505 , 'Failed To Update Password' , []);

        return ApiResponse::sendResponse(200 , 'Password Updated Successfully' , []);

        
    }
}
