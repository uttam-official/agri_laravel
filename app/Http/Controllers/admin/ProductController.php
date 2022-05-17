<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\SubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\admin\ImageController;
use App\Models\Product;
use App\Models\Productgallery;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $SubcategoryController;
    private $ImageController;
    public function __construct(SubcategoryController $SubcategoryController, ImageController $ImageController)
    {
        $this->SubcategoryController = $SubcategoryController;
        $this->ImageController = $ImageController;
    }
    public function index()
    {
        $products = DB::table('products as p')
            ->join('categories as c', function ($join) {
                $join->on('p.category', '=', 'c.id')
                    ->where('c.isactive', '=', 1);
            })
            ->join('categories as s', function ($join) {
                $join->on('p.subcategory', '=', 's.id')
                    ->where('s.isactive', '=', 1);
            })->select('p.id', 'c.name as category', 's.name as subcategory', 'p.name', 'p.price', 'p.availability')
            ->where('p.isactive', '=', 1)
            ->get()->all();
        $data['page_data'] = $products;
        return view('admin/product/product', $data);
    }
    public function add($id = 0)
    {
        if ($id > 0) {
            $product = Product::where('isactive', '=', 1)->find($id);
            if ($product == null) {
                return redirect('admin/product')->with('product_error', 'Bad Request');
            }
            $product->gallery = Productgallery::where('product_id', '=', $id)->get()->all();
            $data['title'] = "Edit Product";
            $data['id'] = $id;
            $data['btn_text'] = "Edit";
            $data['category_list'] = $this->SubcategoryController->get_category();
            $data['subcategory_list'] = $this->get_subcategory_by_id($product->category);
            $data['product'] = $product;
            return view('admin/product/add_product', $data);
        } else {
            $data['title'] = "Add Product";
            $data['id'] = $id;
            $data['btn_text'] = "Add";
            $data['category_list'] = $this->SubcategoryController->get_category();
            $data['product'] = false;
            return view('admin/product/add_product', $data);
        }
    }
    protected function save(Request $request)
    {
        $imageValidation = $request->id > 0 ? 'max:102410|dimensions:min_width=1000,min_height=1000|mimes:jpg,png,jpeg' : 'required|max:102410|dimensions:min_width=1000,min_height=1000|mimes:jpg,png,jpeg';
        $request->validate([
            'id' => 'required|numeric|min:0',
            'category' => 'required|numeric',
            'subcategory' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => $imageValidation,
            'gallery.*' => 'required|max:102410|dimensions:min_width=1000,min_height=1000|mimes:jpg,png,jpeg'
        ]);
        $id = $request->id;
        if ($id > 0) {
            $status = 1;
            $product = Product::where('isactive', '=', 1)->find($id);
            if ($product == null) {
                return redirect('admin/product')->with('product_error', 'Bad Request');
            }
            $hasImage = $request->hasFile('image');
            $hasImage ? $image = $request->file('image') : '';
            $product->name = $request->name;
            $product->slug_url = Str::slug($request->name);
            $product->description = $request->description;
            $product->category = $request->category;
            $product->subcategory = $request->subcategory;
            $product->price = $request->price;
            $hasImage ? $product->image_extension = $image->getClientOriginalExtension() : '';
            $product->availability = $request->availability;
            $product->special = $request->special == 'on' ? 1 : 0;
            $product->featured = $request->featured == 'on' ? 1 : 0;
            if ($product->save()) {
                $hasImage ? $status = $this->ImageController->resizeImage($image, $id, 'product') : '';
            }
            if ($status && $request->hasFile('gallery')) {
                Productgallery::where('product_id', '=', $id)->delete();
                foreach ($request->file('gallery') as $k => $gallery) {
                    $productgallery = new Productgallery();
                    $productgallery->product_id = $id;
                    $productgallery->extension = $id . '_' . $k . '.' . $gallery->getClientOriginalExtension();
                    $productgallery->save();
                    $status = $this->ImageController->resizeImage($gallery, $id . '_' . $k, 'productgallery');
                }
            }
            return redirect('admin/product')->with('product_success', 'Product Updated Successfully');
        } else {
            $image = $request->file('image');
            $product = new Product();
            $product->name = $request->name;
            $product->slug_url = Str::slug($request->name);
            $product->description = $request->description;
            $product->category = $request->category;
            $product->subcategory = $request->subcategory;
            $product->price = $request->price;
            $product->image_extension = $image->getClientOriginalExtension();
            $product->availability = $request->availability;
            $product->special = $request->special == 'on' ? 1 : 0;
            $product->featured = $request->featured == 'on' ? 1 : 0;
            if ($product->save()) {
                $id = $product->id;
                $status = $this->ImageController->resizeImage($image, $id, 'product');
            }
            if ($status && $request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $k => $gallery) {
                    $productgallery = new Productgallery();
                    $productgallery->product_id = $id;
                    $productgallery->extension = $id . '_' . $k . '.' . $gallery->getClientOriginalExtension();
                    $productgallery->save();
                    $status = $this->ImageController->resizeImage($gallery, $id . '_' . $k, 'productgallery');
                }
            }
            return redirect('admin/product')->with('product_success', 'Product Added Successfully');
        }
    }
    protected function delete($id)
    {
        $product = Product::where('isactive', '=', 1)->find($id);
        if ($product == null) {
            return redirect('admin/product')->with('product_error', 'Bad Request');
        }
        $product->isactive=-1;
        if($product->save()){
            return redirect('admin/product')->with('product_error','Product Deleted Successfully');
        }
    }
    protected function get_subcategory(Request $request)
    {
        $subcategory = $this->get_subcategory_by_id($request->category);
        echo json_encode($subcategory);
    }
    public static function get_subcategory_by_id($id)
    {
        $subcategory = DB::table('categories as s')
            ->join('categories as c', function ($join) {
                $join->on('s.parent', '=', 'c.id')
                    ->where('c.isactive', '=', 1);
            })
            ->select('s.id', 's.name')
            ->where('s.parent', '=', $id)
            ->where('s.isactive', '=', 1)
            ->orderBy('s.name')
            ->get()->all();
        return $subcategory;
    }
}
