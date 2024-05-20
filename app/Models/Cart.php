<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    static public function productAddToCart($product_id)
    {
        $user = Auth::user();

        if( $user ){
            return self::where("order_id", NULL)->where('product_id', $product_id)->where('user_id', Auth::user()->id )->first();  
        }
    }
}
