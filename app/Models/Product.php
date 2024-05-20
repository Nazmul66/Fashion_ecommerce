<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    static public function getSingleProduct($slug)
    {
        return self::select('products.*', 'categories.name as cat_name', 'sub_categories.name as subCat_name', 'categories.slug as cat_slug', 'sub_categories.slug as subCat_slug' )
                         ->join('categories', 'categories.id', '=', 'products.category_id' )
                         ->join('sub_categories', 'sub_categories.id', '=', 'products.subCategory_id' )
                         ->where('products.status', 1)
                         ->where('products.is_delete', 0)
                         ->where('products.slug', $slug)->first();
    }

    static public function getCategoryWiseCount($cat_id)
    {
        return self::where('category_id', $cat_id)->count();
    }

    static public function relatedProduct($product_id, $subCat_id)
    {
        $query = self::select('products.*', 'categories.name as cat_name', 'categories.slug as cat_slug', 'sub_categories.name as subCat_name', 'sub_categories.slug as subCat_slug')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'products.subCategory_id')
            ->where('products.id', '!=' , $product_id)
            ->where('products.subCategory_id', '=' , $subCat_id)
            ->where('products.status', 1)
            ->where('products.is_delete', 0)
            ->get();

        return $query;
    }

    static public function getRecord()
    {
        return self::select('products.*', 'categories.name as cat_name', 'sub_categories.name as subCat_name', 'brands.name as brand_name', 'categories.slug as cat_slug', 'sub_categories.slug as subCat_slug')
                    ->join('categories', 'categories.id', '=', 'products.category_id' )
                    ->join('sub_categories', 'sub_categories.id', '=', 'products.subCategory_id' )
                    ->join('brands', 'brands.id', '=', 'products.brand_id' )
                    ->where('products.status', 1)
                    ->where('products.is_delete', 0)
                    ->get();
    }

    //____ NOTE: This is the main filter options and Important part ____//
    static public function getProduct( $cat_id = '', $subCat_id = '')
    {
        // dd(request()->get('start_price'));
        $query = self::select('products.*', 'categories.name as cat_name', 'categories.slug as cat_slug', 'sub_categories.name as subCat_name', 'sub_categories.slug as subCat_slug')
                        ->join('categories', 'categories.id', '=', 'products.category_id')
                        ->leftJoin('sub_categories', 'sub_categories.id', '=', 'products.subCategory_id')
                        ->where('products.status', 1)
                        ->where('products.is_delete', 0);

            if (!empty($cat_id)) {
               $query->where('products.category_id', $cat_id);
            }

            if (!empty($subCat_id)) {
                 $query->where('products.subCategory_id', $subCat_id);
            }

            if (!empty(request()->get('subCategory_id'))) {
                 $subCategory_id = rtrim((request()->get('subCategory_id')), ',');
                 $subCategory_id_array =  explode(',', $subCategory_id);

                //  dd( $subCategory_id_array);
                 $query->whereIn('products.subCategory_id' , $subCategory_id_array);
            }
            else{
               if (!empty(request()->get('old_Category_id'))) {
                    $query->where('products.category_id', request()->get('old_Category_id'));
                 }
     
                 if (!empty(request()->get('old_subCategory_id'))) {
                      $query->where('products.subCategory_id', request()->get('old_subCategory_id'));
                 }
            }

            if (!empty(request()->get('color_id'))) {
                 $color_id = rtrim((request()->get('color_id')), ',');
                 $color_id_array =  explode(',', $color_id);

                //  dd( $color_id_array);
                 $query->join('product_colors', 'products.id', '=', 'product_colors.product_id' )
                       ->whereIn('product_colors.color_id' , $color_id_array);
            }

            if (!empty(request()->get('brand_id'))) {
                 $brand_id = rtrim((request()->get('brand_id')), ',');
                 $brand_id_array =  explode(',', $brand_id);

                //  dd( $brand_id_array);
                 $query->whereIn('products.brand_id' , $brand_id_array);
            }

            if (!empty(request()->get('sortBy'))) {

                 $order = ( request()->get('sortBy'));
                 
                if( $order === 'asc' ){
                    $query->orderBy('products.title' , 'asc');
                }
                else if ( $order === 'desc' ){
                    $query->orderBy('products.title' , 'desc');
                }
                else if ( $order === 'lh' ){
                    $query->orderBy('products.selling_price' , 'asc');
                }
                else if ( $order === 'hl' ){
                    $query->orderBy('products.selling_price' , 'desc');
                }
                
            }

            if ( !empty(request()->get('start_price')) && !empty(request()->get('end_price'))) {
                    $start_price = str_replace('$', '', request()->get('start_price'));
                    $end_price = str_replace('$', '', request()->get('end_price'));
                    // dd($start_price, $end_price);
                    $query->whereBetween('products.selling_price', [$start_price, $end_price]);
            }

            // NOTE: Group by product ID to prevent duplicates
            $query->groupBy('products.id');

            $returns = $query->paginate(9);

        return $returns;
    }

    static public function singleProduct($product_id)
    {
       return self::where('id', $product_id)->first();
    }

}
