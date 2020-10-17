<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function order(){

        $auth_user_id=Auth()->user()->id;
        //get cart details
        $cart_id=Cart::where('user_id',$auth_user_id)->where('status','Cart')->first();
        $cart_items=CartDetail::where('cart_id',$cart_id->id)->get();
        $cart_items_price=CartDetail::where('cart_id',$cart_id->id)->sum('price');
        $tax= $cart_items_price*.07;
        $shipping_cost=200;
        $total=$cart_items_price+$tax+$shipping_cost;

        $order=Order::create([
            "user_id" => $auth_user_id,
            "status" => "New",
            "subtotal" => $cart_items_price,
            "tax" => $tax,
            "shipping_cost" =>$shipping_cost,
            "total" => $total,
        ]);

        foreach($cart_items as $item){
            OrderDetail::create([
                "order_id" => $order->id,
                "product_id" => $item->product_id,
                "product_name" => $item->product_name,
                "price" => $item->price,
                "quantity" => $item->quantity,
            ]);
        }

        return response()->json('The order has been processed',200);
        
    }
}
