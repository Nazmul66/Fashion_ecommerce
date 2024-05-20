<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    use HasFactory;

    static public function getRecords($product_id)
    {
        return self::where('product_id', $product_id)->get();
    }

    static public function getAllImageRecord($product_id)
    {
       return self::where('product_id', $product_id)->get();
    }
}
