<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        // session()->forget('shipping_address');
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
        $checkout = [
            "subtotal" => $request->subtotal,
            "discount" => $request->discount,
            "vat" => $request->vat,
            "ecotax" => $request->ecotax,
            "total" => $request->total
        ];
        session()->put('checkout', $checkout);
        echo json_encode(['status' => 1]);
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
    public function success()
    {
        if (session()->has('order_success')) {
            $data['title'] = "Order Success";
            $data['order_id'] = session()->get('order_success');
            return view('client.success', $data);
        } else {
            return redirect('/');
        }
    }
    protected function add_address(Request $request)
    {
        $address = new Address();
        $address->customer_id = session()->get('user_id');
        $address->company = $request->company;
        $address->address1 = $request->address1;
        $address->address2 = $request->address2;
        $address->city = $request->city;
        $address->postcode = $request->postcode;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->save();
        echo json_encode(['status' => 1]);
    }
    public function cancel_order()
    {
        session()->forget('cart');
        session()->forget('checkout');
        return redirect('/');
    }
    protected function place_order()
    {
        $ordersummery = [
            'customer_id' => session()->get('user_id'),
            'billing_id' => session()->get('billing_address'),
            'shipping_id' => session()->get('shipping_address'),
            'subtotal' => session()->get('checkout.subtotal'),
            'discount' => session()->get('checkout.discount'),
            'vat' => session()->get('checkout.vat'),
            'ecotax' => session()->get('checkout.ecotax'),
            'total' => session()->get('checkout.total'),
            'payment_status' => 1,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ];
        $order_id = DB::table('ordersummery')->insertGetId($ordersummery);
        foreach (session()->get('cart') as $l) {
            $orderinfo = [
                'ordersummery_id' => $order_id,
                'product_id' => $l->id,
                'product_price' => $l->price,
                'quantity' => $l->qty,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ];
            DB::table('orderinfo')->insert($orderinfo);
        }
        $this->send_confirmation(
            $order_id,
            session()->get('checkout'),
            session()->get('cart'),
            session()->get('billing_address'),
            session()->get('shipping_address'),
            session()->get('user_first_name'),
            session()->get('user_last_name'),
            session()->get('user_email'),

        );
        session()->forget('checkout');
        session()->forget('cart');
        return redirect('/success')->with('order_success', $order_id);
    }
    protected function send_confirmation($order_id, $checkout, $cart, $billing, $shipping, $firstname, $lastname, $email)
    {
        $name = $firstname . ' ' . $lastname;
        $email = session()->get('user_email');
        $data['order_id'] = $order_id;
        $data['billing'] = $this->get_address($billing);
        $data['shipping'] = $this->get_address($shipping);
        $data['cart'] = $this->get_cart_product($cart);
        $data['checkout'] = (object) $checkout;
        $data['firstname'] = $firstname;
        $data['lastname'] = $lastname;

        Mail::send('client.email_template.ordersuccess', $data, function ($message) use ($order_id, $name, $email) {
            $message->to($email)->subject('Order Confirmation #' . $order_id);
        });
    }
    protected function get_address($id)
    {
        $data = (array) DB::table('addresses')->where('id', '=', $id)->get(['company', 'address1', 'address2', 'city', 'state', 'country', 'postcode'])->first();
        return implode(',', array_filter($data));
    }
    protected function get_cart_product($cart)
    {
        $data = '';
        foreach ($cart as $l) {
            $data .= $this->get_single_cart_product($l);
        }
        return $data;
    }
    protected function get_single_cart_product($l)
    {
        return '
        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
        <tbody>
          <tr>
            <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
              <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
              <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                <tbody>
                  <tr>
                    <td class="o_re o_bg-white o_px o_pt" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 16px;">
                      <!--[if mso]><table cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td width="200" align="center" valign="top" style="padding: 0px 8px;"><![endif]-->
                      <div class="o_col o_col-2 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                        <div class="o_px-xs o_sans o_text o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: center;padding-left: 8px;padding-right: 8px;">
                          <p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-primary" href="#" style="text-decoration: none;outline: none;color: #126de5;"><img src="'.asset('upload/product/medium/'.$l->id.'.'.$l->image_extension).'" width="184" height="184" alt="" style="max-width: 184px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>
                        </div>
                      </div>
                      <!--[if mso]></td><td width="300" align="left" valign="top" style="padding: 0px 8px;"><![endif]-->
                      <div class="o_col o_col-3 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">
                        <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                        <div class="o_px-xs o_sans o_text o_text-light o_left o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;">
                          <h4 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;">' . $l->name . '</h4>
                          
                          <p class="o_text-xs o_mb-xs" style="font-size: 14px;line-height: 21px;margin-top: 0px;margin-bottom: 8px;">
                            Price: ' . $l->price . '<br>
                            Quantity: ' . $l->qty . '
                          </p>
                        </div>
                      </div>
                      <!--[if mso]></td><td width="100" align="right" valign="top" style="padding: 0px 8px;"><![endif]-->
                      <div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">
                        <div class="o_hide-xs" style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                        <div class="o_px-xs o_sans o_text o_text-secondary o_right o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;">
                          <p style="margin-top: 0px;margin-bottom: 0px;">$' . $l->price * $l->qty . '</p>
                        </div>
                      </div>
                      <!--[if mso]></td></tr><tr><td colspan="3" style="padding: 0px 8px;"><![endif]-->
                      <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                          <tbody>
                            <tr>
                              <td class="o_re o_bb-light" style="font-size: 16px;line-height: 16px;height: 16px;vertical-align: top;border-bottom: 1px solid #d3dce0;">&nbsp; </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso]></td></tr></table><![endif]-->
                    </td>
                  </tr>
                </tbody>
              </table>
              <!--[if mso]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
        ';
    }
}
