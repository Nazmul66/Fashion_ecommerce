<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class SubCategory extends Model
{
    use HasFactory;

    static public function getRecord(){
        return self::where('status', 1)->where('is_delete', 0)->get();
    }

    static public function getSingleSlug($slug){
        return self::where('slug', '=', $slug)
                    ->where('status', 1)
                    ->where('is_delete', 0)
                    ->first();
    }

    static public function getAllRecords($subCat_id){
        return self::where('category_id', $subCat_id)->where('status', 1)->where('is_delete', 0)->get();
    }

    static public function findRecord($id){
        return self::find($id);
    }

}
