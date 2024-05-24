<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    static public function getRecord(){
        return self::where('status', 1)->where('is_delete', 1)->get();
    }

    static public function findRecord($id){
        return self::find($id);
    }


    static public function checkDiscountData($discountName){
        return self::where('name', $discountName)
                    ->where('expire_date', '>=', date('Y-m-d'))
                    ->where('status', 1)
                    ->where('is_delete', 1)
                    ->first();
    }
}
