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
    public static function get_cart(){
        return session()->has('cart')?session()->get('cart'):array();
    }
    
    
}
/*
//PRODUCT ADD TO CART
function add_to_cart($id, $qty, $connect)
{
    $q = $connect->prepare("SELECT id,name,image_extension,price FROM product WHERE id=:id");
    $q->execute([':id' => $id]);
    $product = $q->fetch(PDO::FETCH_ASSOC);
    $product['qty'] = (int) $qty;
    // var_dump($data[$id]['qty']);exit;
    session_status() == 1 ? session_start() : '';
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        if (isset($_SESSION['cart'][$id])) {
            $product['qty'] = $_SESSION['cart'][$id]['qty'] + $product['qty'];
            $_SESSION['cart'][$id] = $product;
        } else {
            $_SESSION['cart'][$id] = $product;
        }
    } else {
        $_SESSION['cart'] = array();
        $_SESSION['cart'][$id] = $product;
    }
    // unset($_SESSION['cart'][3]);
    // var_dump($_SESSION['cart'][2]['qty']);exit;
    return 1;
}
//UPDATE CART QUANTITY
function update_cart($id, $qty)
{
    session_status() == 1 ? session_start() : '';
    $_SESSION['cart'][$id]['qty'] = $qty;
    if (isset($_SESSION['checkout'])) {
        unset($_SESSION['checkout']);
        return 0;
    }
    return 1;
}

//PRODUCT REMOVE FROM CART
function remove_cart($id)
{
    session_status() == 1 ? session_start() : '';
    unset($_SESSION['cart'][$id]);
    if (isset($_SESSION['checkout'])) {
        unset($_SESSION['checkout']);
        return 0;
    }
    return 1;
}
*/