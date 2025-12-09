<?php

namespace App\Http\Controllers\api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function get_categories(Request $request)
    {
        $categories = Category::all();

        return ApiResponse::sendResponse(200 , 'Categories Retrieved Successfully' , $categories);
    }
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|exists:categories,id',
        ], [], []);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, $validator->messages()->first(),[]);
        }
        // get user name for show in screen
        $user_name = $request->user()->name;

        // get products , with category_id is exists and search if exists
        $products = Product::when($request->category_id , fn ($query)
        => $query->where('category_id' , $request->category_id))
        ->when($request->search , fn($q)
        => $q->where('name' , 'like' , '%' . $request->search . '%'))
        ->latest()->paginate(4);

        if(count($products) < 1)
            return ApiResponse::sendResponse(200 , 'Products Are empty' , []);

        return ApiResponse::sendResponse(200 , 'Products Retrieved Successfully' ,
        ['user_name' => $user_name ,
        'products' => ProductResource::collection($products),
        'pagination' => 
        [
            'current_page' =>  $products->currentPage(),
            'last_page' =>  $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' =>  $products->total(),
        ]
        ]);
    }

}
