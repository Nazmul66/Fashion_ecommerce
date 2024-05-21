<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    static public function getRecords($id)
    {
        if( !empty($id) ){
            return self::where('product_id', $id)->get();
        }
    }


    static public function deleteRecord($Product_id)
    {
       return self::where('product_id', $Product_id)->delete();
    }

    static public function getAllColorRecord($product_id)
    {
       return self::select('colors.name as color_name', 'product_colors.color_id as color_id' )
                    ->join('colors', 'colors.id', '=' , 'product_colors.color_id')
                    ->where('product_id', $product_id)
                    ->get();
    }
}
