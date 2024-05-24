<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

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

       $discount_code = Discount::checkDiscountData($request->discount_code);

       if( !empty( $discount_code ) ){
            return response()->json([
                'status' => true,
                'message' => $discount_code
        ]);
       }
       else{
          return response()->json([
               'status' => false,
               'message' => 'Coupon already exists'
          ]);
       }
    }
}
