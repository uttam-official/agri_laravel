<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FunctionController extends Controller
{
    public static function get_category()
    {
        $category = DB::table('categories')
            ->select('id','name', 'slug_url')->where('isactive', '=', 1)
            ->where('parent', '=', 0)
            ->orderBy('categoryorder')
            ->get()->all();
        return $category;
    }
    public static function get_subcategory($id)
    {
        $subcategory = DB::table('categories')
            ->select('name', 'slug_url')->where('isactive', '=', 1)
            ->where('parent', '=', $id)
            ->orderBy('categoryorder')
            ->get()->all();
        return $subcategory;
    }
    public static function get_cart(){
        return session()->has('cart')?session()->get('cart'):array();
    }
    
    
}