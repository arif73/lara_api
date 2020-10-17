<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartDetail;
use DB;
class CartController extends Controller
{   

    // public function __construct(){

    //     $this->middleware('auth:api');
    // }

    public function addToCart($id){

        $product=Product::findOrFail($id);
        $auth_user_id=Auth()->user()->id;
        // if cart is empty then this the first product
        $cart_exists=Cart::where('user_id',$auth_user_id)->Where('status','Cart')->first();

        if(!$cart_exists){

            $new_cart=Cart::Create([
                'user_id' => $auth_user_id,
                'status'  => 'Cart',
            ]);

            CartDetail::Create([
                "cart_id" => $new_cart->id,
                "product_id" => $product->id,
                "product_name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
            ]);

            return response()->json('Product Added Successfully',201);
        }

        else{
            $double_check=CartDetail::where('cart_id',$cart_exists->id)->Where('product_id',$id)->first();
            // if item not exist in cart then add to cart with quantity = 1
            if(!$double_check){
                CartDetail::Create([
                    "cart_id" => $cart_exists->id,
                    "product_id" => $product->id,
                    "product_name" => $product->name,
                    "price" => $product->price,
                    "quantity" => 1,
                ]);
                return response()->json('Product Added Successfully',201);
            }
            else{
                // if cart not empty then check if this product exist then increment quantity
                $double_check->increment('quantity');
                return response()->json('Product Increment Successfully',200);

            }
            
            
        }


    }

    public function deleteCartItem($id){
        $item=CartDetail::find($id);
        $item->delete();
        return response()->json('Item Delete Successfully',200);
    }
}
