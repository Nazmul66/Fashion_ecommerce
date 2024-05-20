<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $subCategories = SubCategory::getRecord();
        $categories    = Category::getRecord();
        return view('backend.pages.subCategory.manage', compact('subCategories', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $subCategory = new SubCategory();

        $subCategory->category_id        =  $request->cat_id;
        $subCategory->name               =  $request->subCat_name;
        $subCategory->slug               =  Str::slug($request->subCat_name);
        $subCategory->meta_title         =  $request->meta_title;
        $subCategory->meta_description   =  $request->meta_description;
        $subCategory->meta_keywords      =  $request->meta_keyword;
        $subCategory->status             =  $request->status;

        $subCategory->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subCategory = SubCategory::findRecord($id);

        $subCategory->category_id        =  $request->cat_id;
        $subCategory->name               =  $request->subCat_name;
        $subCategory->slug               =  Str::slug($request->subCat_name);
        $subCategory->meta_title         =  $request->meta_title;
        $subCategory->meta_description   =  $request->meta_description;
        $subCategory->meta_keywords      =  $request->meta_keyword;
        $subCategory->status             =  $request->status;

        $subCategory->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::findRecord($id);

        $subCategory->is_delete = 1;

        $subCategory->save();

        return redirect()->back();
    }
}
