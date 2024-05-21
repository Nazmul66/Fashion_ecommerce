<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\MOdels\Product;

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

    static public function getCartUserData()
    {
        return self::select('products.*', 'carts.product_price as price', 'carts.product_qty as qty', 'carts.product_id as product_id')
                    ->join('products', 'products.id', '=' , 'carts.product_id')
                    ->where('order_id', NULL)
                    ->where('user_id', Auth::user()->id)
                    ->get();
    }
}
