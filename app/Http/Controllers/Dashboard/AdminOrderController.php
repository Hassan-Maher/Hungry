<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{

    public function index()
    {
        $user = User::where('is_admin' , true)->first();
        $orders = $user->orders()->paginate(10);

        $orders_count   = $user->orders()->count();
        $success_orders = $user->orders()->where('status' , 'paid')->count();
        $failed_orders  = $user->orders()->where('status' , 'rejected')->count();
        $pending_orders = $user->orders()->where('status' , 'pending')->count();


        return view('AdminOrder.index' , compact('orders' , 'orders_count' , 'success_orders' , 'pending_orders' , 'failed_orders'));
        
    }
    public function store(OrderRequest $request)
    {
        $user = User::where('is_admin' , true)->first();
        $validated_data = $request->validated();
        $cart = $user->cart;

        if(!$cart ||  !$cart->items->count())
        {
            return redirect()->back()->withErrors(['error' => "Cart Is Empty , Add Your Product"]);  
        }

        $order = Order::create([
            'user_id'       => $cart->user_id,
            'price'         => $cart->price,
            'phone'         => $validated_data['phone'],
            'address'       => $validated_data['address']??$request->user()->address,
            'payment_method_id' => $validated_data['payment_method']
        ]);

        if($request->has('set_as_prefer') && $request->set_as_prefer == true)
        {
            $cart->user->update(['prefer_payment_method' => $validated_data['payment_method']]);
        }

        if(!$order)
            return redirect()->back()->withErrors(['error' => "Order Have Not Been Created"]);  

        $items = $cart->items;

        foreach($items as $item)
        {
            $order_item = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price_of_product' => $item->price_of_product,
                'total_price' => $item->total_price,
            ]);

            if($item->options)
            {
                foreach($item->options as $option)
                {
                    OrderItemOption::create([
                        'order_item_id'   => $order_item->id,
                        'optionable_type' => $option->optionable_type,
                        'optionable_id'   => $option->optionable_id,
                        'price'           => $option->price,
                    ]);
                }
            }

            $item->delete();
            $cart->update(['price' => 0]);

        }
        return redirect()->route('products.index')->with(['message' => "Order Stored Successfully,"]);  
    }

    
}
