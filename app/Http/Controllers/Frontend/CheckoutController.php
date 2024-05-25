<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ShippingCharge;

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
    public function create()
    {
        //
    }

}
