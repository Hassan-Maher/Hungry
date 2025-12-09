<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserAccountController extends Controller
{
    public function edit(Request $request)
    {
        $user = User::where('is_admin' , true)->first();

        if(!$user)
            redirect()->route('dashboard')->withErrors(['error' => "You Dont Have User Account"]);

        return view('UserAccount.edit' , compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::where('is_admin' , true)->first();
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id),],
            'address'   => ['required' , 'string']
        ], [], []);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' =>$validator->messages()->first()]) ;
        }

        $user->update($request->all());

        return redirect()->back()->with(['message' => "Account Updated Successfully"]);
    }

    public function update_password(Request $request)
    {
        $user = User::where('is_admin' , true)->first();
        $validator = Validator::make($request->all(), [
            'password'      => ['required', 'string', 'confirmed'],
        ], [], []);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' =>$validator->messages()->first()]) ;
        }

        $user->update(['password' => $request->password]);

        return redirect()->back()->with(['message' => "Password Updated Successfully"]);

    }

}
