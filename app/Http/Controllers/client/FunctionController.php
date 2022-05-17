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
            ->get()->all();
        return $category;
    }
    public static function get_subcategory($id)
    {
        $subcategory = DB::table('categories')
            ->select('name', 'slug_url')->where('isactive', '=', 1)
            ->where('parent', '=', $id)
            ->get()->all();
        return $subcategory;
    }
    
}
