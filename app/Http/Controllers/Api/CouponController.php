<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $cart = $request->user()->cart;
        if(!$cart || !$cart->items->count())
        {
            return ApiResponse::sendResponse(403 , "Cart Is Empty , 'pease add your products" , ['is_empty' => true]);
        }
        $validator = Validator::make($request->all(), [
            'coupon' => 'required|string|exists:coupons,code',
        ], [], []);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, $validator->messages()->first(),[]);
        }
        $coupon = Coupon::where('code' , $request->coupon)->first();

        if($coupon->status =='in_active')
        {
            return ApiResponse::sendResponse(403 , "Coupon Is In Active" , ['is_active' => false]);
        }
        if($coupon->expires_at && $coupon->expires_at < now())
        {
            return ApiResponse::sendResponse(403 , "Coupon Has Expires" , ['has_expires' => true]);
        }

        if($coupon->type == 'precentage')
        {
            $discount = $cart->price*$coupon->discount_value /100;
        }
        else{
            $discount = $coupon->discount_value;
        }

        if($cart->price <= $discount)
        {
            return ApiResponse::sendResponse(403 , 'Coupon Is Equal or Greater Than Cart Price' , []);
        }

        $cart->update(['coupon_id' => $coupon->id , 'coupon_discount' => $discount]);

        return ApiResponse::sendResponse(200 , "Coupon Applied Successfully" , [ 'coupon_id' => $coupon->id , 'coupon' => $coupon->code , 'coupon_discount' => $discount]);
    }

    public function delete(Request $request )
    {
        $cart = $request->user()->cart;

        $cart->update(['coupon_id' => null , 'coupon_discount' => 0]);
        return ApiResponse::sendResponse(200 , "coupon Removed Successfully" , []);
    }


}
