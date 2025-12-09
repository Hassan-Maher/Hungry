<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Requests\StoreOptionRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemOption;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SideOption;
use App\Models\Topping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('is_admin' , true)->first();
        if(!$user)
        {
            return redirect()->back()->withErrors(['error' => "You do not have a User account, please create one first."]);    
        }
        $cart = $user->cart;
        
        return view('cart.index' , compact('cart'));

    }

    public function store(CartRequest $request)
    {
        $user = User::where('is_admin' , true)->first();
        if(!$user)
        {
            return redirect()->back()->withErrors(['error' => "You do not have a User account, please create one first."]);    
        }
    
        $validated_data = $request->validated();
            
            // create cart if not exists
            $cart = Cart::firstOrCreate([
                'user_id' => $user->id],
                [
                'price'   => 0 // default 
            ]);

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
                return "Item Failed To Create";
            
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

            return redirect()->route('products.index')->with(['message' => "Product Added To Cart Successfully."]);
    }

    public function destroy(Request $request , $item_id)
    {

        $item = CartItem::find($item_id);
        
        if(!$item)
        {
            return redirect()->back()->withErrors(['error' => "Item Not Found"]);    
        }        

        $cart = $item->cart;

        $item->delete();

        $cart->update(['price' => $cart->price()]);

        return redirect()->back()->with(['message' => "Product Deleted from Cart Successfully."]);
    }

    public function increment(Request $request , $item_id)
    {
        $item = CartItem::find($item_id);
        if(!$item)

        return redirect()->back()->withErrors(['error' => "Item Not Found"]);    

        $new_quantity = $item->quantity+=1;

        $item->update(['quantity' => $new_quantity]);

        $item->update(['total_price' => $item->total_price()]);

        $item->cart->update(['price' => $item->cart->price()]);

        return redirect()->back()->with(['message' => "Quantity Increment  Successfully."]);
    } 

    public function decrement(Request $request , $item_id)
    {
        $item = CartItem::find($item_id);
        
        if(!$item)
        return redirect()->back()->withErrors(['error' => "Item Not Found"]);    


        if($item->quantity >1)
        {
            $new_quantity = $item->quantity-=1;

            $item->update(['quantity' => $new_quantity]);
            
            $item->update(['total_price' => $item->total_price()]);

            $item->cart->update(['price' => $item->cart->price()]);

            return redirect()->back()->with(['message' => "Quantity decrement  Successfully."]);

        }
        else{
            return redirect()->back()->withErrors(['error' => "Quantity Of Item Is 1"]);    
        }

    }

    public function create_option(Request $request , $item_id)
    {
        $item = CartItem::find($item_id);

        if(!$item)
            return redirect()->back()->withErrors(['error' => "Item Not Found"]);  
        
        $toppings = Topping::get();

        $side_options = SideOption::get();
        return view('cart.optionCreate' , compact('toppings' , 'side_options' , 'item'));

    }
    public function store_option(StoreOptionRequest $request , $item_id)
    {
        $validated_data = $request->validated();
        $item = CartItem::find($item_id);

        if(!$item)
            return redirect()->back()->withErrors(['error' => "Item Not Found"]);    


       
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


            return redirect()->route('cart.index')->with(['message' => "options Added Successfully"]);    

    }

    public function destroy_option(Request $request , $option_id)
    {
        $option = CartItemOption::find($option_id);

        if(!$option)
            return redirect()->back()->withErrors(['error' => "Item Not Found"]);    
        
        $item = $option->cartItem;
        $cart = $item->cart;


        $option->delete();
        // update cart price after items created
            $item->update(['total_price' => $item->total_price()]);
            $cart = $item->cart;
            $cart->update(['price' => $cart->price()]);
            $cart->fresh();

        return redirect()->back()->with(['message' => "option Deleted  Successfully."]);
    }

    public function checkout(Request $request)
    {
        $user = User::where('is_admin' , true)->first();

        $cart = $user->cart;

        $cart_items = $cart->items;

        if(count($cart_items) < 1 || !$cart)
        {
            return redirect()->back()->withErrors(['error' => "Cart Is Empty , Add Your Product"]);    
        }

        $order_summary = [];
        $order_summary['order_price'] = $cart->price;
        
        $order_summary['additional_cost'] = Setting::first();
        
        $order_summary['total'] = $order_summary['order_price'] + $order_summary['additional_cost']->taxes + $order_summary['additional_cost']->delivery_fees;

        $payment_methods = PaymentMethod::get();

        $prefered_method = $user->prefer_payment_method??null;
        return view('cart.OrderSummary' , compact('order_summary' , 'payment_methods' , 'prefered_method'));

    }

}
