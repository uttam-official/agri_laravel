<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends Controller
{
    public function index()
    {
        $data['page_data'] =DB::table('categories as s')
                ->join('categories as c',function($join){
                    $join->on('s.parent','=','c.id')
                    ->where('c.isactive','=',1);
                })
                ->select('s.id','s.name','s.categoryorder','c.name as parent_name','s.isactive')
                ->where('s.parent','>',0)
                ->where('s.isactive','>',-1)
                ->get()->all();
         
        return view('admin/subcategory/subcategory', $data);
    }
    public function add($id = 0)
    {
        if ($id > 0) {
            $subcategory=Category::where('parent','>',0)->where('isactive','>',-1)->find($id);
            if($subcategory==null){
                return redirect('admin/subcategory')->with('subcategory_error','bad Request !');
            }
            $data['category_list'] = $this->get_category();
            $data['title'] = "Edit Subcategory";
            $data['btn_text'] = "Edit";
            $data['id']=$id;
            $data['data']=$subcategory;
            return view('admin/subcategory/add_subcategory',$data);
            
        } else {
            $data['category_list'] = $this->get_category();
            $data['title'] = "Add Category";
            $data['btn_text'] = "Add";
            return view('admin/subcategory/add_subcategory', $data);
        }
    }
    protected function save(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|min:0',
            'parent' => 'required',
            'name' => 'required|max:50|unique:categories,name,'.$request->id,
            'categoryorder' => 'required|numeric',
            'isactive' => 'required'
        ]);
        $id=$request->id;
        if($id>0){
            $subcategory=Category::where('parent','>',0)->where('isactive','>',-1)->find($id);
            if($subcategory==null){
                return redirect('admin/subcategory')->with('subcategory_error','bad Request !');
            }
            $subcategory->name=$request->name;
            $subcategory->slug_url=Str::slug($request->name);
            $subcategory->parent=$request->parent;
            $subcategory->isactive=$request->isactive;
            $subcategory->categoryorder=$request->categoryorder;
            if($subcategory->save()){
                return redirect('admin/subcategory')->with('subcategory_success','Subcategory Updated Successfully');
            }else{
                return redirect('admin/subcategory')->with('subcategory_error','Something Wents Wrong !!');
            }

        }else{
            $subcategory=new Category();
            $subcategory->name=$request->name;
            $subcategory->slug_url=Str::slug($request->name);
            $subcategory->parent=$request->parent;
            $subcategory->categoryorder=$request->categoryorder;
            $subcategory->isactive=$request->isactive;
            $subcategory->extension='';
            if($subcategory->save()){
                return redirect('admin/subcategory')->with('subcategory_success','Subcategory Added Successfully');
            }else{
                return redirect('admin/subcategory')->with('subcategory_error','Something Wents Wrong !!');
            }
        }
    }
    protected function delete($id)
    {
        $subcategory = $subcategory=Category::where('parent','>',0)->where('isactive','>',-1)->find($id);
        if ($subcategory == null) {
            return redirect('admin/subcategory')->with('subcategory_error', 'Bad Request !');
        }
        $subcategory->isactive = -1;
        if ($subcategory->save()) {
            return redirect('admin/subcategory')->with('subcategory_error', 'Subcategory Deleted Successfully');
        }
    }
    public function get_category()
    {
        $category = Category::where('isactive', '=', '1')
            ->where('parent', '=', 0)
            ->orderBy('name')
            ->get()
            ->all();
        return $category;
    }
}
