<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_size;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

                // dd($cart);
                $cart->save();
            }

           return redirect()->route('cart.show');

        }

    }


    /**
     * Display the specified resource.
     */
    public function cartShow()
    {
        $userCartData = Cart::getCartUserData();
        return view('frontend.pages.cart.cart', compact('userCartData'));
    }


    public function updateCartQuantity(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
    
        // Find the cart item for the current user
        $cartItem = Cart::where('order_id', NULL)
                        ->where('user_id', Auth::user()->id)
                        ->where('product_id', $productId)
                        ->first();
    
        if ( $cartItem ) {
            // Update the quantity
            $cartItem->product_qty = $quantity;
            $cartItem->save();
    
            // Calculate the new totals
            $cartTotal = Cart::select('products.*', 'carts.product_price as product_price', 'carts.product_qty as product_qty', 'carts.product_id as product_id')
                             ->join('products', 'products.id', '=' , 'carts.product_id')
                             ->where('order_id', NULL)
                             ->where('user_id', Auth::user()->id)
                             ->sum(DB::raw('product_price * product_qty'));

            $cartQty = Cart::select('products.*', 'carts.product_price as product_price', 'carts.product_qty as product_qty', 'carts.product_id as product_id')
                             ->join('products', 'products.id', '=' , 'carts.product_id')
                             ->where('order_id', NULL)
                             ->where('user_id', Auth::user()->id)
                             ->value('product_qty');
    
            return response()->json([
                'status' => true,
                'newItemTotal' => $cartItem->product_price * $cartItem->product_qty,
                'cartTotal' => intval($cartTotal),
                'quantity' => $cartQty,
            ]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Cart item not found'], 404);
        }
    
    }


    /**
     * Remove the specified resource from storage.
     */
    public function getCartData(Request $request)
    {
        $cart = Cart::getCartUserData();

        return response()->json([
            'status' => true,
            'success' => $cart,
        ]);
    }


    public function deleteCart(Request $request, $id)
    {
        // dd($id);
        $cart = Cart::find($id);
        // dd($cart);
        
        $cart->delete();
        
        return redirect()->back();
        
    }

}
