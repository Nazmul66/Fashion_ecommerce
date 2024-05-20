<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $categories = Category::getRecord();
        return view('backend.pages.category.manage', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new Category();

        $category->name               =  $request->cat_name;
        $category->slug               =  Str::slug($request->cat_name);
        $category->meta_title         =  $request->meta_title;
        $category->meta_description   =  $request->meta_description;
        $category->meta_keywords      =  $request->meta_keyword;
        $category->status             =  $request->status;

        $category->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findRecord($id);

        $category->name               =  $request->cat_name;
        $category->slug               =  Str::slug($request->cat_name);
        $category->meta_title         =  $request->meta_title;
        $category->meta_description   =  $request->meta_description;
        $category->meta_keywords      =  $request->meta_keyword;
        $category->status             =  $request->status;

        $category->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findRecord($id);

        $category->is_delete = 1;

        $category->save();

        return redirect()->back();
    }
}
