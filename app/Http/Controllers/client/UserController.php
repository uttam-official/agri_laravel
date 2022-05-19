<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Address;
class UserController extends Controller
{
    public function index(){
        return View('client.login');
    }
    protected function login_validation(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $password=$request->password;
        $customer=Customer::where('isactive','=',1)->where('email','=',$request->email)->get(['id','firstname','lastname','email','password'])->first();
        $status=false;
        if($customer!=null){
            $status=password_verify($password,$customer->password);
        }
        if($status){
            session()->put('user_id',$customer->id);
            session()->put('user_first_name',$customer->firstname);
            session()->put('user_last_name',$customer->lastname);
            session()->put('user_email',$customer->email);
            return redirect('/billing');
        }else{
            return redirect('login')->with('login_error','Enter valid email and password');
        }

    }
    public function register_view(){
        return view('client.register');
    }
    protected function register(Request $request){
        // var_dump($request->all());
        $request->validate([
            'firstname'=>'required|max:25',
            'lastname'=>'required|max:25',
            'email'=>'required|max:50|email|unique:customers',
            'phone'=>'required|digits:10',
            // 'fax'=>'required_if:type,individual|digits:10',
            'password'=>'required',
            'confirm'=>'required|same:password',
            'newsletter'=>'required',
            'company'=>'max:50',
            'address1'=>'required|max:150',
            'address2'=>'max:150',
            'city'=>'required|max:50',
            'postcode'=>'required|digits:6',
            'country'=>'required|max:50',
            'state'=>'required|max:50',
            'agree'=>'required',

        ]);
        $customer=new Customer();
        $customer->firstname=$request->firstname;
        $customer->lastname=$request->lastname;
        $customer->email=$request->email;
        $customer->phone=$request->phone;
        $customer->fax=$request->fax;
        $customer->password=password_hash($request->password,PASSWORD_BCRYPT);
        $customer->newsletter=$request->newsletter;
        if($customer->save()){
            $address=new Address();
            $address->customer_id=$customer->id;
            $address->company=$request->company;
            $address->address1=$request->address1;
            $address->address2=$request->address2;
            $address->city=$request->city;
            $address->postcode=$request->postcode;
            $address->country=$request->country;
            $address->state=$request->state;
            $address->save();
        }
        return redirect('/login')->with('register_success',"You have registered successfully !");
    }
    protected function logout(){
        session()->forget('user_id');
        session()->forget('user_email');
        session()->forget('user_name');
        return redirect('login');
    }
}
