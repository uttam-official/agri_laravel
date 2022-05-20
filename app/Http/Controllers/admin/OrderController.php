<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    public function index(){
        $data['order']=DB::table('ordersummery as o')
        ->join('customers as c',function($join){
            $join->on('o.customer_id','=','c.id');
        })
        ->join('order_status as os',function($join){
            $join->on('o.order_status','=','os.id');
        })
        ->select('o.id','o.shipping_id','o.created_at','o.total','os.name as status','o.order_status','c.firstname','c.lastname')
        ->where('o.isactive','=',1)
        ->orderBy('o.created_at','DESC')
        ->get()->all();
        return view('admin.order.order',$data);
    }
    protected function cancel(Request $request){
        $order=Order::find($request->id);
        $order->order_status=-1;
        $order->save();
        echo json_encode(['status'=>1]);
    }
    protected function delete($id){
        $order=Order::where('isactive','>',-1)->find($id);
        if($order==null){return redirect()->back()->with('order_error','Bad Request');}
        $order->isactive=-1;
        $order->save();
        return redirect()->back()->with('order_error','Order id: ' . $id . ' deleted successfully !');
    }
    public function edit($id){
        $data['order']=Order::where('isactive','>',-1)->find($id);
        if($data['order']==null){return redirect()->back()->with('order_error','Bad Request');}
        return view('admin/order/order_edit',$data);
    }
    protected function edit_order(Request $request){
        $order=Order::where('isactive','=',1)->find($request->id);
        if($order==null){return redirect('admin/order')->with('order_error','Bad Request');}
        $order->payment_status=$request->payment_status;
        $order->order_status=$request->order_status;
        $order->save();
        return redirect()->back()->with('order_edit_success','Order successfully edited!');
    }
}
