<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Address;
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
            ->leftJoin('productgallery as g', function ($join) {
                $join->on('p.id', '=', 'g.product_id');
            })
            ->select('p.*', 'c.name as category_name', 'c.slug_url as category_slug', 's.name as subcategory_name', 's.slug_url as subcategory_slug', DB::raw('group_concat(g.extension) as gallery'))
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
        return view('client.category', $data);
    }
    public function get_related_product($c_id, $p_id)
    {
        $related = DB::table('products as p')
            ->join('categories as c', function ($join) use ($c_id) {
                $join->on('p.category', '=', 'c.id')
                    ->where('c.id', '=', $c_id);
            })
            ->select('p.id', 'p.name', 'p.slug_url', 'p.price', 'p.image_extension')
            ->where('p.isactive', '=', 1)
            ->where('p.id', '<>', $p_id)
            ->get()->all();
        return $related;
    }
    protected function cart()
    {
        $data['page_data'] = session()->has('cart') ? session()->get('cart') : array();
        return view('client.cart', $data);
    }
    protected function add_to_cart(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        if (session()->has('cart.' . $id)) {
            $product = session()->get('cart.' . $id);
            $product->qty += $qty;
            session()->put('cart.' . $id, $product);
        } else {
            $product = DB::table('products')
                ->select('id', 'name', 'slug_url', 'image_extension', 'price')
                ->where('id', '=', $id)
                ->where('isactive', '=', 1)
                ->get()->first();
            $product->qty = $qty;
            session()->put('cart.' . $id, $product);
        }
        echo json_encode(['status' => 1]);
    }
    protected function remove_cart(Request $request)
    {
        session()->forget('cart.' . $request->id);
        session()->forget('checkout');
        echo json_encode(['status' => 1]);
    }
    protected function update_cart(Request $request)
    {
        $product = session()->get('cart.' . $request->id);
        $product->qty = $request->qty;
        session()->put('cart.' . $request->id, $product);
        session()->forget('checkout');
        echo json_encode(['status' => 1]);
    }
    public function get_session()
    {
        session()->forget('shipping_address');
        var_dump(session()->all());
    }
    protected function validate_coupon(Request $request)
    {
        $coupon = DB::table('discounts')
            ->select('validfrom', 'validtill', 'amount', 'type')
            ->where('isactive', '=', 1)
            ->where('name', '=', $request->coupon)
            ->get()->first();
        if ($coupon != null) {
            $validfrom = $coupon->validfrom;
            $validtill = $coupon->validtill;
            $stat1 = $validfrom != null ? (date('Y-m-d', strtotime($validfrom)) <= date('Y-m-d') ? 1 : 0) : 1;
            $stat2 = $validtill != null ? (date('Y-m-d', strtotime($validtill)) >= date('Y-m-d') ? 1 : 0) : 1;
            if ($stat1 && $stat2) {
                return ['status' => true, 'amount' => $coupon->amount, 'type' => $coupon->type];
            } else {
                return ['status' => false];
            }
        } else {
            return ['status' => false];
        }
    }
    protected function checkout(Request $request)
    {
        if (session()->has('cart') && session()->get('cart') != null) {
            $subtotal = 0;
            $ecotax = 0;
            foreach (session()->get('cart') as $id => $value) {
                $ecotax += 2;
                $subtotal += $value->qty * $value->price;
            }
            $vat = $subtotal * 20 / 100;
            $total = $subtotal + $ecotax + $vat;
            $checkout = [
                "subtotal" => $subtotal,
                "discount" => 0,
                "vat" => $vat,
                "ecotax" => $ecotax,
                "total" => $total
            ];
            session()->put('checkout', $checkout);
            echo json_encode(['status' => 1]);
        } else {
            echo json_encode(['status' => 0]);
        }
    }
    public function billing()
    {
        $data['title'] = "Billing Address";
        $data['btn_name'] = "billing";
        $data['address'] = $this->get_user_address();
        return view('client.address', $data);
    }
    public function shipping()
    {
        $data['title'] = "Shipping Address";
        $data['btn_name'] = "shipping";
        $data['address'] = $this->get_user_address();
        // var_dump($data['address']);exit;
        return view('client.address', $data);
    }
    protected function get_user_address()
    {
        $user_id = session()->get('user_id');
        $address = DB::table('addresses')
            ->where('isactive', '=', 1)
            ->where('customer_id', '=', $user_id)
            ->get()->all();
        return $address;
    }
    protected function set_billing(Request $request)
    {
        session()->put('billing_address', $request->address);
        return redirect('shipping');
    }
    protected function set_shipping(Request $request)
    {
        session()->put('shipping_address', $request->address);
        return redirect('payment');
    }
    public function payment()
    {
        if (!session()->has('shipping_address')) {
            return redirect('shipping')->with('shipping_error', 'Please select shipping address first');
        }
        if (!session()->has('billing_address')) {
            return redirect('billing')->with('billing_error', 'Please select billing address first');
        }
        if (session()->has('checkout')) {
            $data['title'] = "payment";
            $data['total'] = session()->get('checkout.total');
            return view('client.payment', $data);
        } else {
            return redirect('cart')->with('payment_error', 'Please check out first');
        }
    }
    public function success(){
        if(session()->has('order_success')){
            $data['title']="Order Success";
            $data['order_id']=session()->get('order_success');
            return view('client.success');
        }else{
            return redirect('/');
        }
    }
    protected function add_address(Request $request){
        $address=new Address();
        $address->customer_id=session()->get('user_id');
        $address->company=$request->company;
        $address->address1=$request->address1;
        $address->address2=$request->address2;
        $address->city=$request->city;
        $address->postcode=$request->postcode;
        $address->state=$request->state;
        $address->country=$request->country;
        $address->save();
        echo json_encode(['status'=>1]);
    }
    public function cancel_order(){
        session()->forget('cart');
        session()->forget('checkout');
        return redirect('/');
    }
    protected function place_order(){
        
    }

}
