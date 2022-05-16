<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index()
    {
        $category = DB::table('categories as c')
            ->leftJoin('categories as s', function ($join) {
                $join->on('c.id', '=', 's.parent')
                    ->where('s.isactive', '>', -1);
            })
            ->select('c.id', 'c.name', 'c.isactive', 'c.categoryorder', DB::raw('count(s.id) as no_sub'))
            ->where('c.isactive', '>', -1)
            ->where('c.parent', '=', 0)
            ->groupBy('c.id')
            ->get()->all();
        return view('admin/category/category', ['page_data' => $category]);
    }
    public function add($id = 0)
    {
        $data = array();
        if ($id > 0) {
            $category = Category::where('parent','=',0)->where('isactive','>',-1)->find($id);
            if ($category == null) {
                return redirect('admin/category')->with('category_error', 'Bad Request !');
            }
            $data = [
                'id' => $id,
                'name' => $category->name,
                'categoryorder' => $category->categoryorder,
                'isactive' => $category->isactive,
                'extension' => $category->extension
            ];
            $data['title'] = "Edit Category ";
            $data['btn_text'] = "Edit";
            return view('admin/category/add_category', $data);
        } else {
            $data['id'] = 0;
            $data['isactive'] = 1;
            $data['title'] = "Add Category ";
            $data['btn_text'] = "Add";
            return view('admin/category/add_category', $data);
        }
    }
    protected function save(Request $request)
    {
        $id = $request->id;
        $img_rule = $id > 0 ? 'mimes:png,jpg,jpeg|dimensions:min_width=70,min-width=70' : 'required|mimes:png,jpg,jpeg|dimensions:min_width=70,min-width=70';
        $request->validate([
            'name' => 'required|max:50',
            'categoryorder' => 'required|numeric',
            'image' => $img_rule,
            'isactive' => 'required'
        ]);
        if ($id > 0) {
            $hasImage = $request->hasFile('image');
            $category = Category::where('parent','=',0)->where('isactive','>',-1)->find($id);
            $category->name = $request->name;
            $category->slug_url = Str::slug($request->name);
            $category->categoryorder = $request->categoryorder;
            $hasImage ? $category->extension = $request->file('image')->getClientOriginalExtension() : '';
            $category->isactive = $request->isactive;
            try {
                $category->save();
                if ($hasImage) {
                    $image = $request->file('image');
                    $name = $category->id . '.' . $image->getClientOriginalExtension();
                    $destination = 'upload/category';
                    $image->move($destination, $name);
                }
                return redirect('admin/category')->with('category_success', 'Category Updated Successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                var_dump($e->getMessage());
            }
        } else {
            $category = new Category();
            $category->name = $request->name;
            $category->slug_url = Str::slug($request->name);
            $category->parent = 0;
            $category->categoryorder = $request->categoryorder;
            $category->extension = $request->file('image')->getClientOriginalExtension();
            $category->isactive = $request->isactive;
            try {
                $category->save();
                $image = $request->file('image');
                $name = $category->id . '.' . $image->getClientOriginalExtension();
                $destination = 'upload/category';
                $image->move($destination, $name);
                return redirect('admin/category')->with('category_success', 'Category Added Successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                var_dump($e->getMessage());
            }
        }
    }
    protected function delete($id)
    {
        $category = Category::where('parent','=',0)->where('isactive','>',-1)->find($id);
        if ($category == null) {
            return redirect('admin/category')->with('category_error', 'Bad Request !');
        }
        $category->isactive = -1;
        if ($category->save()) {
            return redirect('admin/category')->with('category_error', 'Category Deleted Successfully');
        }
    }
}
