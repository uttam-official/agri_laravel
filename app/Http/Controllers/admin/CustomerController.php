<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(){
        $data['customer']=DB::table('customers as c')
        ->leftJoin('ordersummery as o',function($join){
            $join->on('o.customer_id','=','c.id')
            ->where('o.isactive','=',1);
        })
        ->select('c.id','c.firstname','c.lastname','c.email','c.phone','c.isactive',DB::raw('COUNT(o.id) AS no_of_order'))
        ->where('c.isactive','>',-1)
        ->groupBy('c.id')
        ->get()->all();
        return view('admin.customer.customer',$data);
    }
    public function edit($id){
        $data['id']=$id;
        $data['customer']=Customer::where('isactive','>',-1)->find($id);
        if($data['customer']==null){
            return redirect('admin/customer')->with('customer_error','Bad Request !');
        }
        $data['address']=$this->get_address($id);
        return view('admin.customer.customer_edit',$data);
    }
    protected function edit_customer(Request $request){
        $id=$request->id;
        $customer=Customer::where('isactive','>',-1)->find($id);
        if($customer==null){ return redirect('admin/customer')->with('customer_error','Bad Request !');}
        $customer->firstname=$request->fname;
        $customer->lastname=$request->lname;
        $customer->email=$request->email;
        $customer->phone=$request->phone;
        $customer->fax=$request->fax;
        $customer->isactive=$request->isactive;
        $customer->save();
        echo json_encode(['status'=>1]);
    }
    public function delete($id){
        $customer=Customer::where('isactive','>',-1)->find($id);
        if($customer==null){return redirect()->back()->with('customer_error','Bad Request');}
        $customer->isactive=-1;
        $customer->save();
        return redirect()->back()->with('customer_error','Customer deleted successfully !');
    }
    protected function get_address($id){
        return DB::table('addresses')
        ->where('isactive','=',1)
        ->where('customer_id','=',$id)
        ->get()->all();
    }
    protected function edit_address(Request $request){
        $id=$request->id;
        $address=[
            'company'=>$request->company,
            'address1'=>$request->address_1,
            'address2'=>$request->address_2,
            'city'=>$request->city,
            'postcode'=>$request->postcode,
            'country'=>$request->country,
            'state'=>$request->state,
        ];
        DB::table('addresses')->where('id','=',$id)->update($address);
        echo json_encode(['status'=>1]);
    }
    public function order($id){
        $data['order']=DB::table('ordersummery')->where('isactive','=',1)->where('customer_id','=',$id)->get()->all();
        if($data['order']==null){ return redirect('admin/customer')->with('customer_error','Bad Request !');}
        return view('admin.customer.customer_order',$data);
    }
    public static function get_single_address($id){
        $data=(array) DB::table('addresses')
        ->where('id','=',$id)
        ->get(['company','address1','address2','city','country','state','postcode'])->first();
        return implode(',', array_filter($data));
    }
    public static function get_products($id){
         return DB::table('orderinfo as o')
        ->join('products as p',function($join){
            $join->on('o.product_id','=','p.id');
        })
        ->where('o.ordersummery_id','=',$id)
        ->get(['p.name','o.quantity'])->all();
    }
    public static function get_order_status($id){
        return DB::table('order_status')
        ->where('id','=',$id)
        ->get('name')->first()->name;

    }
    public static function get_all_orderstatus(){
        return DB::table('order_status')
        ->where('isactive','=',1)
        ->where('id','>=',0)
        ->get(['id','name'])->all();
    }
}
