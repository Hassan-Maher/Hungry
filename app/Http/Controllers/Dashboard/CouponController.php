<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupons.create');
    }

    public function store(CouponRequest $request)
    {
        $validated_data = $request->validated();

        $validated_data['uses_count'] = 0;

        Coupon::create($validated_data);

        return redirect()->route('coupons.index')->with('message', 'Coupon created successfully');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupons.edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $validated_data = $request->validated();

        $coupon->update($validated_data);

        return redirect()->route('coupons.index')->with('message', 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('message', 'Coupon deleted successfully');
    }
}
