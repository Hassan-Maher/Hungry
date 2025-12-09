<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payment_methods = PaymentMethod::get();
        

        return view('PaymentMethod.index' , compact('payment_methods'));
    }

    public function create()
    {
        return view('PaymentMethod.create');
    }

    public function store(Request $request)
    {
        PaymentMethod::create(['name' => $request->name]);

        return redirect()->route('payment_method.index')->with(['message' => "PaymentMethod Added Successfully"]);
    }

    public function edit($method_id)
    {
        $method = PaymentMethod::findOrFail($method_id);
        return view('PaymentMethod.edit', compact('method'));
    }


    public function update(Request $request , $method_id)
    {

        $payment_method = PaymentMethod::findOrFail($method_id);

        $payment_method->update(['name' => $request->name]);
        
        return redirect()->route('payment_method.index')->with(['message' => "PaymentMethod Updated Successfully"]);

    }

    public function destroy(Request $request , $method_id)
    {
        $payment_method = PaymentMethod::findOrFail($method_id);

        $payment_method->delete();

        return redirect()->back()->with(['message' => "Payment Method Deleted Successfully"]);
    }

}
