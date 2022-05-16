<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index(){
        return view('admin/dashboard');
    }
    public function login(){
        // var_dump(Admin::all()->toArray());
        return view('admin/login');
    }
    protected function loginValidate(Request $request){
        // echo password_hash('123456',PASSWORD_BCRYPT);exit;
        $data=(object) $request->all();
        $admin=Admin::where('email','=',$data->email)->get(['id','name','password'])->first();
        // var_dump($admin==null);exit;
        if($admin!=null){
            $admin=(object) $admin->toArray();
            if(password_verify($data->password,$admin->password)){
                session()->put('admin',['admin_id'=>$admin->id,'admin_name'=>$admin->name]);
                return redirect('admin');
            }
            return redirect('admin/login')->with('login_error','Please Enter valid email id and password !');
        }
        return redirect('admin/login')->with('login_error','Please Enter valid email id and password !');
    }
    public function logout(){
        session()->forget('admin');
        return redirect('admin/login');
    }
    public function settings(){
        $admin_id=session()->get('admin')['admin_id'];
        $admin=Admin::where('id','=',$admin_id)->get('email')->first();
        return view('admin/settings',['id'=>$admin_id,'email'=>$admin['email']]);
        
    }
    protected function updateSettings(Request $request){
        $admin_id=session()->get('admin')['admin_id'];
        $admin=Admin::find($admin_id);
        $admin->email=$request->email;
        $admin->password=password_hash($request->password,PASSWORD_BCRYPT);
         if($admin->save()){
             session()->forget('admin');
             return redirect('admin/login')->with('password_update','Your session expired ... Please login');
         }
    }
}
