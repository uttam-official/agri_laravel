<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index(){
        $data['page_data']=Discount::where('isactive','>',-1)->get()->all();
        return view('admin/discount/discount',$data);
    }
    public function add($id=0){
        if($id>0){
            $discount=Discount::where('isactive','>',-1)->find($id);
            if($discount==null){
                return redirect('admin/discount')->with('discount_error', 'Bad Request !');
            }
            $data=[
                'name'=>$discount->name,
                'validfrom'=>$discount->validfrom,
                'validtill'=>$discount->validtill,
                'amount'=>$discount->amount,
                'type'=>$discount->type,
                'isactive'=>$discount->isactive,
            ];
            $data['title']="Edit Discount Coupon";
            $data['id']=$id;
            $data['btn_text']="Edit";
            $data['discount']=false;
            return view('admin/discount/add_discount',$data);

        }else{
            $data['title']="Add Discount Coupon";
            $data['id']=0;
            $data['btn_text']="Add";
            $data['discount']=false;
            return view('admin/discount/add_discount',$data);
        }
    }
    protected function save(Request $request){
        $request->validate([
            'id'=>'required|numeric|min:0',
            'name'=>'required|alpha_num|max:20|unique:discounts,name,'.$request->id,
            'type'=>'required|numeric|min:1|max:2',
            'amount'=>'required|numeric|min:1',
            'isactive'=>'required'
        ]);
        $id=$request->id;
        if($id>0){
            $discount=Discount::where('isactive','>',-1)->find($id);
            if($discount==null){
                return redirect('admin/discount')->with('discount_error', 'Bad Request !');
            }
            $discount->name=$request->name;
            $discount->validfrom=$request->validfrom;
            $discount->validtill=$request->validtill;
            $discount->type=$request->type;
            $discount->amount=$request->amount;
            $discount->isactive=$request->isactive;
            if($discount->save()){
                return redirect('admin/discount')->with('discount_success','Discount Coupon Updated Successfully!');
            }else{
                return redirect('admin/discount')->with('discount_error','Something Wents Wrong !');
            }
        }else{
            $discount=new Discount();
            $discount->name=$request->name;
            $discount->validfrom=$request->validfrom;
            $discount->validtill=$request->validtill;
            $discount->type=$request->type;
            $discount->amount=$request->amount;
            $discount->isactive=$request->isactive;
            if($discount->save()){
                return redirect('admin/discount')->with('discount_success','Discount Coupon Added Successfully !');
            }else{
                return redirect('admin/discount')->with('discount_error','Something Wents Wrong !');
            }
        }
    }
    protected function delete($id){
        $discount = Discount::find($id);
        if ($discount == null) {
            return redirect('admin/discount')->with('discount_error', 'Bad Request !');
        }
        $discount->isactive = -1;
        if ($discount->save()) {
            return redirect('admin/discount')->with('discount_error', 'Discount Deleted Successfully');
        }
    }
}
