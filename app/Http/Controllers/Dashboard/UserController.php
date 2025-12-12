<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role' , 'user')->when($request->search , function ($query) use($request){
            $query->where('name' , 'like' , '%' . $request->search.'%')
            ->Orwhere('email' , $request->search);
        })->get();

        $users_count  = User::count();
        $active_users = User::where('is_bolcked' , false)->count();
        $blocked_users = User::where('is_bolcked' , true)->count();
        
        
        return view('Users.index' , compact('users','users_count' , 'active_users' , 'blocked_users'));
    }
    public function block($user_id)
    {
        $user = User::findOrFail($user_id);

        if($user)
            $user->update(['is_bolcked' => true]);
        return to_route('users.index');
    }
    public function active($user_id)
    {
        $user = User::findOrFail($user_id);
        
        if($user)
            $user->update(['is_bolcked' => false]);

        return to_route('users.index');
    }

    public function show(Request $request , $user_id)
    {
        $user = User::with('orders')->findOrFail($user_id);
        $orders_count = $user->orders->count();

        $orders = $user->orders()->latest()->paginate(10);

        return view('Users.show' , compact('user' , 'orders_count' , 'orders'));

    }
}
