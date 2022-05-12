<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

use function PHPUnit\Framework\isNull;

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
            return redirect('admin/login');
        }
        return redirect('admin/login');
    }
    public function logout(){
        session()->forget('admin');
        return redirect('admin/login');
    }
}
