<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_size extends Model
{
    use HasFactory;

    static public function getRecords($Product_id)
    {
       return self::where('product_id', $Product_id)->get();
    }

    static public function deleteRecord($Product_id)
    {
       return self::where('product_id', $Product_id)->delete();
    }

    static public function getAllSizeRecord($product_id)
    {
       return self::where('product_id', $product_id)->get();
    }

    static public function getProductSize($size_id)
    {
       return self::where('id', $size_id)->first();
    }
}
