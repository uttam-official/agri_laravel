<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $data['special'] = DB::table('products')
            ->select('id', 'name', 'slug_url', 'price', 'image_extension')
            ->where('special', '=', 1)
            ->where('isactive', '=', 1)
            ->orderBy(DB::raw('RAND()'))
            ->get()->all();
        $data['featured'] = DB::table('products')
            ->select('id', 'name', 'slug_url', 'price', 'image_extension')
            ->where('featured', '=', 1)
            ->where('isactive', '=', 1)
            ->orderBy(DB::raw('RAND()'))
            ->get()->all();
        $data['category'] = DB::table('categories')
            ->select('id', 'name', 'slug_url', 'extension')
            ->where('isactive', '=', 1)
            ->where('parent', '=', 0)
            ->orderBy('categoryorder')
            ->get()->all();
        return view('client/index', $data);
    }
    public function product($uri)
    {
        $data['product'] = DB::table('products as p')
            ->join('categories as c', function ($join) {
                $join->on('c.id', '=', 'p.category')
                    ->where('c.isactive', '=', 1);
            })
            ->join('categories as s', function ($join) {
                $join->on('s.id', '=', 'p.subcategory')
                    ->where('s.isactive', '=', 1);
            })
            ->leftJoin('productgallery as g',function($join){
                $join->on('p.id','=','g.product_id');
            })
            ->select('p.*','c.name as category_name','c.slug_url as category_slug','s.name as subcategory_name','s.slug_url as subcategory_slug',DB::raw('group_concat(g.extension) as gallery'))
            ->where('p.slug_url', '=', $uri)
            ->where('p.isactive', '=', 1)
            ->groupBy('p.id')
            ->get()->first();
            // var_dump($data);exit;
        $data['related'] = $this->get_related_product($data['product']->category, $data['product']->id);

        return view('client/product', $data);
    }
    public function category($category, $subcategory = '')
    {

        $data['products'] = $subcategory == '' ?
            DB::table('products as p')
            ->join('categories as c', function ($join) use ($category) {
                $join->on('p.category', '=', 'c.id')
                    ->where('c.isactive', '=', 1)
                    ->where('c.slug_url', '=', $category);
            })

            ->select('p.*')
            ->where('p.isactive', '=', 1)
            ->get()->all()
            : DB::table('products as p')
            ->join('categories as c', function ($join) use ($category) {
                $join->on('p.category', '=', 'c.id')
                    ->where('c.isactive', '=', 1)
                    ->where('c.slug_url', '=', $category);
            })->join('categories as s', function ($join) use ($subcategory) {
                $join->on('p.subcategory', '=', 's.id')
                    ->where('s.isactive', '=', 1)
                    ->where('s.slug_url', '=', $subcategory);
            })

            ->select('p.*')
            ->where('p.isactive', '=', 1)
            ->get()->all();
        return view('client.category',$data);
    }
    public function get_related_product($c_id, $p_id)
    {
        $related = DB::table('products as p')
            ->join('categories as c', function ($join) use ($c_id) {
                $join->on('p.category', '=', 'c.id')
                    ->where('c.id', '=', $c_id);
            })
            ->select('p.id','p.name','p.slug_url','p.price','p.image_extension')
            ->where('p.isactive', '=', 1)
            ->where('p.id', '<>', $p_id)
            ->get()->all();
        return $related;
    }
}
