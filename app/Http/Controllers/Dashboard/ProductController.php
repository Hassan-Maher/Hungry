<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SideOption;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products_count = Product::count();
        $products = Product::with('category')->when($request->search , function ($query) use($request){
            $query->where('name' , 'like' , '%' . $request->search.'%')
            ->Orwhere('price' , $request->search);
        })->latest()->paginate(8);

        return view('Products.index' , compact('products' , 'products_count'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $validated_data = $request->validated();

        // رفع الصورة
        $validated_data['img'] = $request->file('img')->store('products', 'public');

        Product::create($validated_data);

        return redirect()->route('products.index')->with('success', 'Product Created Successfully');
    }
    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);
        $categories = Category::all();
        return view('Products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, $product_id)
    {
        
        $product = Product::findOrFail($product_id);
        $validated_data = $request->validated();

        if ($request->hasFile('img')) {
            // حذف القديمة
            if ($product->img && Storage::disk('public')->exists($product->img)) {
                Storage::disk('public')->delete($product->img);
            }

            // حفظ الجديدة
            $validated_data['img'] = $request->file('img')->store('products', 'public');
        }

        $product->update($validated_data);

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }

    public function destroy($product_id)
    {
        $product = Product::findOrFail($product_id);
        // حذف الصورة
        if ($product->img && Storage::disk('public')->exists($product->img)) {
            Storage::disk('public')->delete($product->img);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }

    public function show(Request $request , $product_id)
    {
        $product = Product::findOrFail($product_id);

        $toppings = Topping::get();

        $side_options = SideOption::get();

        return view('Products.show' , compact('product' , 'toppings' , 'side_options'));
    }

    

}
