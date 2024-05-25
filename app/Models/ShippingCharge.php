<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;


    protected $table = 'shipping_charges';

    static public function getRecord(){
        return self::where('status', 1)->where('is_delete', 1)->get();
    }

    static public function findRecord($id){
        return self::find($id);
    }

}
