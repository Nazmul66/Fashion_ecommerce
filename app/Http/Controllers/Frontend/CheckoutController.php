<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ShippingCharge;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function checkout()
    {
        $carts = Cart::getCartUserData();
        $shippingCharges = ShippingCharge::getRecord();
        return view('frontend.pages.checkout.checkout', compact('carts', 'shippingCharges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout_place_order(Request $request)
    {

        $order = new Order();

        $order->user_id               = Auth::user()->id;
        $order->first_name            = $request->first_name;
        $order->last_name             = $request->last_name;
        $order->email                 = $request->email;
        $order->phone                 = $request->phone;
        $order->company_name          = $request->company_name;
        $order->address               = $request->address;
        $order->address_optional      = $request->address_optional;
        $order->country               = $request->country;
        $order->city                  = $request->city;
        $order->state                 = $request->state;
        $order->postcode              = $request->postcode;
        $order->order_note            = $request->order_note;
        $order->discount_price        = $request->discount_price;
        $order->shipping_price        = $request->shipping_price;
        $order->total_cart_price      = $request->total_cart_price;
        $order->payment_method        = $request->payment_method;
        $order->is_delete             = 1;
        $order->status                = 0;

        // dd($order);

        $order->save();

        // clear the all cart data
        foreach( Cart::where('order_id', null)->get() as $cart ){
            $cart->order_id =  $order->id;
            $cart->save();
        }

        return redirect()->back();
    }

}
