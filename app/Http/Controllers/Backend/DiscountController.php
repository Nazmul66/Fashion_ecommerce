<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Cart;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $discounts = Discount::getRecord();
        return view('backend.pages.discount.manage', compact('discounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $discount = new Discount();

        $discount->name               =  $request->name;
        $discount->type               =  $request->type;
        $discount->percent_amount     =  $request->percent_amount;
        $discount->expire_date        =  $request->expire_date;
        $discount->status             =  $request->status;

        $discount->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $discount = Discount::findRecord($id);

        $discount->name               =  $request->name;
        $discount->type               =  $request->type;
        $discount->percent_amount     =  $request->percent_amount;
        $discount->expire_date        =  $request->expire_date;
        $discount->status             =  $request->status;

        $discount->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = Discount::findRecord($id);
        
        $discount->is_delete = 1;
        
        $discount->save();
        
        return redirect()->back();
    }

    public function discount_code(Request $request)
    {
    //    dd($request->discount_code);
       $carts = Cart::getCartUserData();
       $subTotal = 0; 
       foreach( $carts as $cart ){
           $subTotal += $cart->price * $cart->qty;
       }


       $discount_code = Discount::checkDiscountData($request->discount_code);

       if( !empty( $discount_code ) ){
          if( $discount_code->type === "amount" ){
              $discount_amount   = $discount_code->percent_amount;
              $total             = $subTotal - $discount_code->percent_amount;
          }
          else if( $discount_code->type === "percent" ){
              $discount_amount     = $discount_code->percent_amount;
              $percentage_amount   = ($subTotal * $discount_code->percent_amount) / 100;
              $total               = $subTotal - $percentage_amount;
          }

          return response()->json([
            'status' => true,
            'discount_amount' => $discount_amount,
            'total' => $total,
        ]);

       }

       else{
            return response()->json([
                'status' => false,
                'discount_amount' => 0,
                'total' => $subTotal,
            ]);
       }







    //    if( !empty( $discount_code ) ){
    //         return response()->json([
    //             'status' => true,
    //             'message' => $discount_code
    //     ]);
    //    }
    //    else{
    //       return response()->json([
    //            'status' => false,
    //            'message' => 'Coupon already exists'
    //       ]);
    //    }
    }
}
