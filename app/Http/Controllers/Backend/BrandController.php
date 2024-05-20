<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $brands = Brand::getRecord();
        return view('backend.pages.brand.manage', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $brand = new Brand();

        $brand->name               =  $request->brand_name;
        $brand->slug               =  Str::slug($request->brand_name);
        $brand->meta_title         =  $request->meta_title;
        $brand->meta_description   =  $request->meta_description;
        $brand->meta_keywords      =  $request->meta_keyword;
        $brand->status             =  $request->status;

        $brand->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand    = Brand::findRecord($id);

        $brand->name               =  $request->brand_name;
        $brand->slug               =  Str::slug($request->brand_name);
        $brand->meta_title         =  $request->meta_title;
        $brand->meta_description   =  $request->meta_description;
        $brand->meta_keywords      =  $request->meta_keyword;
        $brand->status             =  $request->status;

        $brand->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand    = Brand::findRecord($id);

        $brand->is_delete = 1;

        $brand->save();

        return redirect()->back();
    }
}
