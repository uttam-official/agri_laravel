<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index(){
        $category=Category::where('parent','=',0)->where('isactive','=',1)->orderBy('categoryorder')->get()->all();
        return view('admin/category/category',['page_data'=>$category]);
    }
    public function add($id=0){
        $data=array();
        if($id>0){
            $category=Category::find($id);
            $data=[
                'id'=>$id,
                'name'=>$category->name
            ];
            $data['title']="Edit Category ";
            $data['btn_text']="Edit";
            return view('admin/category/add_category',$data);
        }else{
            $data['id']=0;
            $data['status']=1;
            $data['title']="Add Category ";
            $data['btn_text']="Add";
            return view('admin/category/add_category',$data);
        }
    }
    protected function save(Request $request){
        $id=$request->id;
        $img_rule=$id>0?'mimes:png,jpg,jpeg|dimensions:min_width=70,min-width=70':'required|mimes:png,jpg,jpeg|dimensions:min_width=70,min-width=70';
        $request->validate([
            'name'=>'required|max:50',
            'categoryorder'=>'required|numeric',
            'image'=>$img_rule,
            'isactive'=>'required'
        ]);
        if($id>0){
            
        }else{
            $category=new Category();
            $category->name=$request->name;
            $category->slug_url=Str::slug($request->name);
            $category->parent=0;
            $category->categoryorder=$request->categoryorder;
            $category->extension=$request->file('image')->getClientOriginalExtension();
            $category->isactive=$request->isactive;
            try{
                $category->save();
                $image=$request->file('image');
                $name=$category->id.'.'.$image->getClientOriginalExtension();
                $destination =public_path('/upload/category');
                $image->move($destination,$name);
                echo "data inserted ";
            }catch(\Illuminate\Database\QueryException $e){
                var_dump($e->getMessage());
            }
        }
    }
}
