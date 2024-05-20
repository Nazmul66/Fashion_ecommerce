<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_size;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function productCart(Request $request)
    {
        if( !Auth::check() ){
            return redirect()->route('login');
        }
        else{
           $cart = Cart::productAddToCart($request->product_id);
        }

        if( !empty($cart) ){
            $availableStock = Product::where('id', $cart->product_id)->value('quantity');
            // dd($request->product_qty);

            if ($request->product_qty > $availableStock) {
                // $notifications = [
                //     "message"    => "Sorry, only $availableStock items are available, you can't choose $request->product_qty items",
                //     'alert-type' => "error",
                // ];
                // return redirect()->back()->with($notifications);
                return redirect()->back();
            }

            else if( $cart->product_qty == $availableStock ){
                // $notifications = [
                //     "message"    => "Sorry, only $availableStock items are available, you can't choose $request->product_qty items",
                //     'alert-type' => "error",
                // ];
                // return redirect()->back()->with($notifications);
                return redirect()->back();
            }

            else if( !is_null( $request->product_qty ) ){
                $singleProduct = Product::singleProduct($request->product_id);
                $total_price   = !empty( $singleProduct->discount_price ) ? $singleProduct->discount_price : $singleProduct->selling_price;

                $cart->color_id           = $request->color_id; 
                $cart->product_qty        = $cart->product_qty + $request->product_qty;

                if( !empty($request->size_id) ){
                    $size_id = $request->size_id;
                    $getSize = Product_size::getProductSize($request->size_id);
        
                    $size_price = !empty($getSize->price) ? $getSize->price : 0 ;
                    $total_price = $total_price + $size_price;

                    $cart->size_id         = $size_id;
                    $cart->product_price   = $total_price;
                }
                else{
                    $cart->size_id         = 0;
                    $cart->product_price   = $total_price;
                }

                $cart->save();

                // $notifications = [
                //     "message"    => "Item Quantity updated in your cart",
                //     'alert-type' => "success",
                // ];
        
                // return redirect()->back()->with($notifications);
                return redirect()->back();
            }

            else {
                $singleProduct = Product::singleProduct($request->product_id);
                $total_price   = !empty( $singleProduct->discount_price ) ? $singleProduct->discount_price : $singleProduct->selling_price;

                $cart->increment('product_qty');
                $cart->color_id           = $request->color_id; 

                if( !empty($request->size_id) ){
                    $size_id = $request->size_id;
                    $getSize = Product_size::getProductSize($request->size_id);
        
                    $size_price = !empty($getSize->price) ? $getSize->price : 0 ;
                    $total_price = $total_price + $size_price;

                    $cart->size_id         = $size_id;
                    $cart->product_price   = $total_price;
                }
                else{
                    $cart->size_id         = 0;
                    $cart->product_price   = $total_price;
                }

                $cart->save();

                // $notifications = [
                //     "message"    => "Item Quantity updated in your cart",
                //     'alert-type' => "success",
                // ];
        
                // return redirect()->back()->with($notifications);
                return redirect()->back();
            }

        }

        else{

            $singleProduct = Product::singleProduct($request->product_id);
            $total_price   = !empty( $singleProduct->discount_price ) ? $singleProduct->discount_price : $singleProduct->selling_price;

            $cart = new Cart();

            if( !is_null( $cart ) ){
                    
                $cart->product_id         = $request->product_id; 
                $cart->color_id           = $request->color_id; 
                $cart->product_qty        = $request->product_qty; 
                $cart->user_id            = Auth::user()->id; 

                    if( !empty($request->size_id) ){
                        $size_id = $request->size_id;
                        $getSize = Product_size::getProductSize($request->size_id);
            
                        $size_price = !empty($getSize->price) ? $getSize->price : 0 ;
                        $total_price = $total_price + $size_price;

                        $cart->size_id         = $size_id;
                        $cart->product_price   = $total_price;
                    }
                    else{
                        $cart->size_id         = 0;
                        $cart->product_price   = $total_price;
                    }

                $cart->save();
            }

           return redirect()->back();

        }

    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
