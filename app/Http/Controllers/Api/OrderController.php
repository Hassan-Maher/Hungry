<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\PaymentMethod;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:pending,paid,rejected',
        ], [], []);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, $validator->messages()->first(),[]);
        }
        $user = $request->user();

        $orders = $user->orders()->when($request->status , function($query)use($request){
            $query->where('status' , $request->status);
        })->get();
        

        $orders->load(['items.options.optionable']);

        return ApiResponse::sendResponse(200 ,'orders retrieved successfully' , OrderResource::collection($orders));
    }
    public function store(OrderRequest $request)
    {
        $validated_data = $request->validated();
        $cart = $request->user()->cart;

        if(!$cart ||  !$cart->items->count())
        {
            return ApiResponse::sendResponse(403 , 'Cart Is Empty , Add Your items To Complete Order' , ['is_empty' =>true]);
        }
        $additonal_cost = Setting::first();

        $order = Order::create([
            'user_id'           => $cart->user_id,
            'items_price'             => $cart->price,
            'phone'             => $validated_data['phone'],
            'address'           => $validated_data['address']??$request->user()->address,
            'payment_method_id' => $validated_data['payment_method'],
            'taxes'             => $additonal_cost->taxes??0,
            'delivery_fees'     => $additonal_cost->delivery_fees??0,
            'coupon_id'         => $cart->coupon_id??null,
            'coupon_discount'   => $cart->coupon_discount??0,
            'Final_price'       => $cart->price + $additonal_cost->taxes+ $additonal_cost->delivery_fees - $cart->coupon_discount,
        ]);

        if($request->has('set_as_prefer') && $request->set_as_prefer == true)
        {
            $cart->user->update(['prefer_payment_method' => $validated_data['payment_method']]);
        }

        if(!$order)
            return ApiResponse::sendResponse(505 , 'Failed To Store Order' , []);

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
            $cart->update(['price' => 0 , 'coupon_id' => null , 'coupon_discount' => 0]);

        }
        return ApiResponse::sendResponse(200 , 'Order Stored Successfully' , []);
    }

    public function pay(Request $request , $order_id)
    {
        $order = Order::find($order_id);

        if(!$order)
            return ApiResponse::sendResponse(404 , 'Order Not Found' , ['is_found' => false]);

        if($order->status == 'paid')
        {
            return ApiResponse::sendResponse(403 , 'Order Is Paid Before' , ['is_paid' => true]);
        }

        if($order->status == 'rejected')
        {
            return ApiResponse::sendResponse(403 , 'Order Is rejected' , ['is_rejected' => false]);
        }

        $order->update(['status' => 'paid']);

        $order->load(['items.options' , 'items.product']);

        return ApiResponse::sendResponse(200 , 'Order Success , reciept is send to your email');
    }

    public function show(Request $request , $order_id)
    {
        $order = Order::find($order_id);

        if(!$order)
            return ApiResponse::sendResponse(404 , "Order Not Found" , ['is_found' => false]);

        $order->load(['items.options.optionable']);

        return ApiResponse::sendResponse(200, "Order Retrieved Successfully",new  OrderResource($order));
    }

}
