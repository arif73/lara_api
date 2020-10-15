<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function productList(){
        $productList=Product::all();
        return response()->json($productList,200);
    }
}
