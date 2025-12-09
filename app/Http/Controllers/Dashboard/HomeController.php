<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $users_count = User::where('role' , 'user')->count();
        $active_users = User::where(['is_bolcked' =>  false , 'role' => 'user'])->count();
        $blocked_users = User::where(['is_bolcked' =>  true , 'role' => 'user'])->count();

        $products_count = Product::count();
        $orders_count = Order::count();

        return view('dashboard'  , compact('users_count','active_users','blocked_users','products_count','orders_count'));
    }
}
