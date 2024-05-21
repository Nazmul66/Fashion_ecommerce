<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCategory( $slug, $subslug = '' )
    {
        $getCategory     = Category::getSingleSlug( $slug );
        $getSubCategory  = SubCategory::getSingleSlug( $subslug );
        $getBrands       = Brand::getRecord();
        $getColors       = Color::getRecord();

         if ( !empty( $getCategory ) && !empty($getSubCategory) ) {

            $totalProductCount = Product::getCategoryWiseCount($getCategory->id);
            $subCategoryFilter = SubCategory::getAllRecords($getCategory->id);
            $allProducts = Product::getProduct( $getCategory->id, $getSubCategory->id );
            return view('frontend.pages.product.list', compact('getCategory', 'getSubCategory', 'allProducts', 'subCategoryFilter', 'getBrands', 'getColors', 'totalProductCount'));
        }

        else if (!empty( $getCategory )) { 

            $totalProductCount = Product::getCategoryWiseCount($getCategory->id);
            $subCategoryFilter = SubCategory::getAllRecords($getCategory->id);
            $allProducts = Product::getProduct( $getCategory->id );
            return view('frontend.pages.product.list', compact('getCategory', 'allProducts', 'subCategoryFilter', 'getBrands', 'getColors',  'totalProductCount'));
        }

    }


    public function productDetails(string $slug )
    {
        $singleProduct   = Product::getSingleProduct( $slug );

        if( !empty( $singleProduct ) ){
            $gerRelatedProducts = Product::relatedProduct( $singleProduct->id,  $singleProduct->subCategory_id );

            // dd($gerRelatedProducts);
            return view('frontend.pages.product.product-details', compact('singleProduct', 'gerRelatedProducts'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getProductFilter(Request $request)
    {
        $allProducts = Product::getProduct();
        $totalProductShow = $allProducts->count();
        // dd($allProducts);
        
        return response()->json([
            'status' => true,
            'total' => $totalProductShow,
            'success' => view('frontend.pages.product.product_list', ['allProducts' => $allProducts])->render(),
        ],200);
    }

  
}
