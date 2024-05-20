<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Feature;
use App\Models\ProductColor;
use App\Models\Product_size;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $products = Product::getRecord();
        return view('backend.pages.product.manage', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories     =  Category::getRecord();
        $subCategories  =  SubCategory::getRecord();
        $brands         =  Brand::getRecord();
        $colors         =  Color::getRecord();
        return view('backend.pages.product.create', compact('categories', 'subCategories', 'brands', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $product    =  new Product();

        if( !is_null( $product ) ){
            $product->title                     = $request->title;
            $product->slug                      = Str::slug($request->title);
            $product->sku_code                  = $request->sku_code;
            $product->category_id               = $request->cat_id;
            $product->subCategory_id            = $request->subCat_id;
            $product->brand_id                  = $request->brand_id;
            $product->tags                      = $request->product_tags;
            $product->unit                      = $request->unit;
            $product->is_featured               = $request->is_featured;
            $product->is_trendy                 = $request->is_trendy;
            $product->is_promotion              = $request->is_promotion;
            $product->todays_deal               = $request->todays_deal;
            $product->purchase_price            = $request->purchase_price;
            $product->selling_price             = $request->selling_price;
            $product->discount_price            = $request->discount_price;

            if( $request->file('thumbnail') ){
                $thumbnail = $request->file('thumbnail');

                $imageName          = microtime('.') . '.' . $thumbnail->getClientOriginalExtension();
                $imagePath          = 'public/backend/images/product_thumbnail/';
                $thumbnail->move($imagePath, $imageName);

                $product->thumbnail = $imagePath . $imageName;
            }

            $product->description               = $request->description;
            $product->short_description         = $request->short_description;
            $product->additional_information    = $request->add_information;
            $product->shipping_returns          = $request->shipping_returns;
            $product->admin_id                  = Auth::user()->id;
            $product->status                    = $request->status;
            $product->save();

            if( $request->images ){
               foreach( $request->images as $image ){
                   $productImage = new ProductImages();

                   $imageName         = microtime('.') . '.' . $image->getClientOriginalExtension() ;
                   $imagePath         = 'public/backend/images/product_multiple_image/';
                   $image->move($imagePath, $imageName);

                   $productImage->product_id   = $product->id;
                   $productImage->product_name = $imageName;
                   $productImage->product_path = $imagePath;

                   $productImage->save();
               }
            }

            if( !empty( $request->color ) ){
                foreach($request->color as $color_id){
                    $productColor = new ProductColor();

                    $productColor->product_id     = $product->id;
                    $productColor->color_id       = $color_id;

                    $productColor->save();
                }
            }


            if( !empty( $request->size_name ) ){
                foreach( $request->size_name as $row => $s_name ){
                    $product_size = new Product_size();

                    $product_size->product_id = $product->id;
                    $product_size->name = $s_name ;
                    $product_size->price = $request->size_price[$row];

                    $product_size->save();
                }
            }

            return redirect()->route('product.manage');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product          = Product::find($id);
        $productColors    = ProductColor::getRecords($product->id);
        $productSizes     = Product_size::getRecords($product->id);
        $productImages    = ProductImages::getRecords($product->id);

        $categories       =  Category::getRecord();
        $subCategories    =  SubCategory::getRecord();
        $brands           =  Brand::getRecord();
        $colors           =  Color::getRecord();
        return view('backend.pages.product.edit', compact('product', 'productColors','categories', 'subCategories', 'brands', 'colors', 'productSizes', 'productImages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product        =    Product::find($id);

        if( !is_null( $product ) ){
            $product->title                     = $request->title;
            $product->slug                      = Str::slug($request->title);
            $product->sku_code                  = $request->sku_code;
            $product->category_id               = $request->cat_id;
            $product->subCategory_id            = $request->subCat_id;
            $product->brand_id                  = $request->brand_id;
            $product->tags                      = $request->product_tags;
            $product->unit                      = $request->unit;
            $product->is_featured               = $request->is_featured;
            $product->is_trendy                 = $request->is_trendy;
            $product->is_promotion              = $request->is_promotion;
            $product->todays_deal               = $request->todays_deal;
            $product->purchase_price            = $request->purchase_price;
            $product->selling_price             = $request->selling_price;
            $product->discount_price            = $request->discount_price;

            if( $request->file('thumbnail') ){
                $thumbnail = $request->file('thumbnail');

                if ( !is_null($product->thumbnail) && file_exists($product->thumbnail))  {
                       unlink($product->thumbnail); // Delete the existing thumbnail
                }

                $imageName          = microtime('.') . '.' . $thumbnail->getClientOriginalExtension();
                $imagePath          = 'public/backend/images/product_thumbnail/';
                $thumbnail->move($imagePath, $imageName);

                $product->thumbnail = $imagePath . $imageName;
            }

            $product->description               = $request->description;
            $product->short_description         = $request->short_description;
            $product->additional_information    = $request->add_information;
            $product->shipping_returns          = $request->shipping_returns;
            $product->admin_id                  = Auth::user()->id;
            $product->status                    = $request->status;
            $product->save();

            if( $request->images ){
                foreach( $request->images as $image ){
                    $productImage = new ProductImages();

                    $imageName         = microtime('.') . '.' . $image->getClientOriginalExtension();
                    $imagePath         = 'public/backend/images/product_multiple_image/';
                    $image->move($imagePath, $imageName);

                    $productImage->product_id   = $product->id;
                    $productImage->product_name = $imageName;
                    $productImage->product_path = $imagePath;

                    $productImage->save();
                }
             }

            // existing data delete then store new data
            ProductColor::deleteRecord($product->id);

            if( !empty( $request->color ) ){
                foreach($request->color as $color_id){
                    $productColor = new ProductColor();

                    $productColor->product_id     = $product->id;
                    $productColor->color_id       = $color_id;

                    $productColor->save();
                }
            }

            // existing data delete then store new data
            Product_size::deleteRecord($product->id);

            if( !empty( $request->size_name ) ){
                foreach( $request->size_name as $row => $s_name ){
                    $product_size = new Product_size();

                    $product_size->product_id = $product->id;
                    $product_size->name = $s_name ;
                    $product_size->price = $request->size_price[$row];

                    $product_size->save();
                }
            }

            return redirect()->back();
        }
    }


    public function destroyImage(string $id)
    {
        $productImg = ProductImages::find($id);

        if( !is_null( $productImg ) ){
            if( file_exists( $productImg->product_path . $productImg->product_name )){
                unlink($productImg->product_path . $productImg->product_name);
            }
            $productImg->delete();

            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product    =  Product::find($id);

        if( !is_null( $product ) ){
            $product->is_delete = 1;
            $product->save();

            return redirect()->back();
        }
    }


    // API call
    public function getCategory(Request $request)
    {
        $all_subCategory = SubCategory::where('category_id', $request->data_id )->get();

        return response()->json(['status' => 'success', 'data' => $all_subCategory]);
    }
}
