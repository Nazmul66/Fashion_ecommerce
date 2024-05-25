<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingCharge;

class ShippingController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $shippingCharges = ShippingCharge::getRecord();
        return view('backend.pages.shipping-charge.manage', compact('shippingCharges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $shippingCharge = new ShippingCharge();

        $shippingCharge->name               =  $request->name;
        $shippingCharge->price              =  $request->price;
        $shippingCharge->status             =  $request->status;

        $shippingCharge->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $shippingCharge = ShippingCharge::findRecord($id);

        $shippingCharge->name               =  $request->name;
        $shippingCharge->price              =  $request->price;
        $shippingCharge->status             =  $request->status;

        $shippingCharge->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shippingCharge = ShippingCharge::findRecord($id);
        
        $shippingCharge->is_delete = 1;
        
        $shippingCharge->save();
        
        return redirect()->back();
    }

}
