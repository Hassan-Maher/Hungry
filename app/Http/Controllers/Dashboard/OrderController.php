<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

        $orders_count = Order::count();

        $orders =  Order::paginate(10);

        $success_orders = Order::where('status' , 'paid')->count();
        $failed_orders = Order::where('status' , 'rejected')->count();
        $pending_orders = Order::where('status' , 'pending')->count();

        return view('Order.index' , compact('orders' , 'orders_count' , 'success_orders' , 'pending_orders' , 'failed_orders'));

    }


    public function show(Request $request , $order_id)
    {
        $order = Order::find($order_id);

        if(!$order)
            return redirect()->back()->withErrors(['error' => "Order Not Found"]);

        $order->load(['user' , 'items.options.optionable']);

        return view('Order.show' , compact('order'));
    }
}
