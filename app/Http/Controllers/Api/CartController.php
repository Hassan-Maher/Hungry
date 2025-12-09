<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemOption;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SideOption;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart;

        $cart->load(['items.product' , 'items.options.optionable']);

        // check the cart is empty or (user never add any product => No cart exists in database)
        if(!$cart || !$cart->items()->count())
        {
            return ApiResponse::sendResponse(200 , 'Cart Is Empty , Add Your Products' , ['is_empty' => true]);
        }

        return ApiResponse::sendResponse(200 , 'Cart Retrieved Successfully' , new CartResource($cart));
    }

    public function store(CartRequest $request)
    {
    
            $validated_data = $request->validated();

            // create cart if not exists
            $cart = Cart::firstOrCreate([
                'user_id' => $request->user()->id],
                [
                'price'   => 0 // default 
            ]);

            
            if(!$cart)
            return ApiResponse::sendResponse(505 , 'Failed To Create Cart' , []);

            // get product to put price
            $product = Product::find($validated_data['product_id']);

            // create item 
            $item = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $validated_data['product_id'],
                'quantity' => $validated_data['quantity'],
                'price_of_product' => $product->price,
                'total_price'  => 0   // default
            ]);

            if(!$item)
                return ApiResponse::sendResponse(505 , 'Item Failed To Create' , []);
            
            // add topping if  exists
            if($request->has('toppings'))
            {
                foreach($request->toppings as $toppingId)
                {
                    $topping = Topping::find($toppingId);

                    $topping->cart_options()->create([
                        'cart_item_id' => $item->id,
                        'price' => $topping->price,
                    ]);
                }
            }

            // add side_options if  exists
            if($request->has('side_options'))
            {
                foreach($request->side_options as $side_optionId)
                {
                    $side_option = SideOption::find($side_optionId);

                    $side_option->cart_options()->create([
                        'cart_item_id' => $item->id,
                        'price' => $side_option->price,
                    ]);
                }
            }
            
            // update cart price after items created
            $item->update(['total_price' => $item->total_price()]);

            $cart->update(['price' => $cart->price()]);
            $cart->fresh();

            
            return ApiResponse::sendResponse(200 , 'Item Add To Cart Successfully' , new CartResource($cart));
    }

    public function destroy(Request $request , $item_id)
    {

        $item = CartItem::find($item_id);
        
        if(!$item)
        {
            return ApiResponse::sendResponse(404 , 'Item Not Found' , ['is_found' => false]);
        }

        $cart = $item->cart;

        if($request->user()->id != $cart->user_id)
        {
            return ApiResponse::sendResponse(403 , 'Forbidden' , ['is_allowed' => false]);
        }

        $item->delete();

        $cart->update(['price' => $cart->price()]);

        return ApiResponse::sendResponse(200 , 'Item Deleted Successfully' , []);
    }

    public function increment(Request $request , $item_id)
    {
        $item = CartItem::find($item_id);
        if(!$item)
            return ApiResponse::sendResponse(404 , 'Item Not Found' , ['is_found' => false]);
        
        if($request->user()->cart->id != $item->cart_id)
        {
            return ApiResponse::sendResponse(403 , 'ForBidden' , ['is_allowed' => false]);
        }
        $new_quantity = $item->quantity+=1;

        $item->update(['quantity' => $new_quantity]);

        $item->update(['total_price' => $item->total_price()]);

        $item->cart->update(['price' => $item->cart->price()]);

        return ApiResponse::sendResponse(200 , 'Itme Increment successfully');
    } 

    public function decrement(Request $request , $item_id)
    {
        $item = CartItem::find($item_id);
        
        if(!$item)
            return ApiResponse::sendResponse(404 , 'Item Not Found' , ['is_found' => false]);

        if($request->user()->cart->id != $item->cart_id)
        {
            return ApiResponse::sendResponse(403 , 'ForBidden' , ['is_allowed' => false]);
        }

        if($item->quantity >1)
        {
            $new_quantity = $item->quantity-=1;

            $item->update(['quantity' => $new_quantity]);
            
            $item->update(['total_price' => $item->total_price()]);

            $item->cart->update(['price' => $item->cart->price()]);

            return ApiResponse::sendResponse(200 , 'Item Decrement successfully',[]);
        }
        else{
            return ApiResponse::sendResponse(403 , 'Quantity Is 1 , You Cant Decrement More Than' , []);
        }

    }

    public function store_option(StoreOptionRequest $request , $item_id)
    {
        $validated_data = $request->validated();
        $item = CartItem::find($item_id);

        if(!$item)
            return ApiResponse::sendResponse(404 , 'Item Not Found' , ['is_found' => false]);

        if($request->user()->cart->id != $item->cart_id)
            return ApiResponse::sendResponse(403 , 'For Bidden' , ['is_allowed' => false] );
        $options=[];
        if($request->has('toppings'))
            {
                foreach($request->toppings as $toppingId)
                {
                    $topping = Topping::find($toppingId);

                    $options[]=$topping->cart_options()->create([
                        'cart_item_id' => $item->id,
                        'price' => $topping->price,
                    ]);
                }
            }

            // add side_options if  exists
            if($request->has('side_options'))
            {
                foreach($request->side_options as $side_optionId)
                {
                    $side_option = SideOption::find($side_optionId);

                    $options[] = $side_option->cart_options()->create([
                        'cart_item_id' => $item->id,
                        'price' => $side_option->price,
                    ]);
                }
            }
            
            // update cart price after items created
            $item->update(['total_price' => $item->total_price()]);
            $cart = $item->cart;
            $cart->update(['price' => $cart->price()]);
            $cart->fresh();


            return ApiResponse::sendResponse(200 , "Options Added Successfully" , $options);
    }

    public function destroy_option(Request $request , $option_id)
    {
        $option = CartItemOption::find($option_id);
        
        if(!$option)
            return ApiResponse::sendResponse(404 , 'Option Not Found' , ['is_found' => false]);
        
        $item = $option->cartItem;
        $cart = $item->cart;
        if($request->user()->cart->id != $option->cartItem->cart_id)
            return ApiResponse::sendResponse(403 , 'For Bidden' , ['is_allowed' => false] );

        $deleted_option = $option;
        $option->delete();

        // update cart price after items created
            $item->update(['total_price' => $item->total_price()]);
            $cart = $item->cart;
            $cart->update(['price' => $cart->price()]);
            $cart->fresh();

        return ApiResponse::sendResponse(200 ,'Option Deleted Successfully' ,[]);
    }

    public function checkout(Request $request)
    {
        $cart = $request->user()->cart;

        $cart_items = $cart->items;

        if(count($cart_items) < 1 || !$cart)
        {
            return ApiResponse::sendResponse(203 , 'Cart Is Empty , add Your Items' , ['is_empty' => true]);
        }

        $order_summary = [];
        $order_summary['order_price'] = $cart->price;
        
        $order_summary['additional_cost'] = Setting::first();
        if($cart->coupon_discount != 0)
        {
            $order_summary['coupon_discount'] =  $cart->coupon_discount;
            $order_summary['total_price'] = $order_summary['order_price'] + $order_summary['additional_cost']->taxes + $order_summary['additional_cost']->delivery_fees - $order_summary['coupon_discount'];
        }
        else{

            $order_summary['total_price'] = $order_summary['order_price'] + $order_summary['additional_cost']->taxes + $order_summary['additional_cost']->delivery_fees ;
        }
        
        
        return ApiResponse::sendResponse(200 , 'Check Your order' , $order_summary);
    }

    public function payment_method(Request $request)
    {
        $user = $request->user();

        $payment_methods = PaymentMethod::get();

        $prefered_method = PaymentMethod::where('id' , $user->prefer_payment_method)->first();

        return ApiResponse::sendResponse(200 , 'payment_method retrieved successfully' ,[
        'payment_method' => $payment_methods,
        'prefered_method' => $prefered_method
        ]);
    }


}
