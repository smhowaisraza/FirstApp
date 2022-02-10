<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product as MainTable;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Productimage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public $table="Product";
    public $redirect="product";
    public function index()
    {
      //  $data=MainTable::all(); 
      $data=MainTable::join('brands','brands.id','products.brandid')
      ->join('categories','categories.id','products.categoryid')
      ->select('products.*','categories.name as categoryname','brands.name as brandname')
      ->get();
      //dd($data);
       return View($this->table.".index")->with([$this->redirect.'s'=>$data]);
    }
    public function add()
    {
        $categories=Category::all();
        $brands=Brand::all();
        return View($this->table.".add",compact('brands','categories'));
    }
    public function adddb(Request $req)
    {
        $brand=new MainTable();
        $brand->name=$req->name;
        $brand->price=$req->price;
        $brand->color=$req->color;
        $brand->categoryid=$req->categoryid;
        $brand->brandid=$req->brandid;
        $brand->size=$req->size;
        $brand->save();
        $images=[];
        if($req->hasFile('images'))
        {
            
            foreach($req->file('images') as $image)
            {
                $extension = $image->getClientOriginalExtension();
                $imageName = "product_".Str::random(10)."_".time().'.'.$extension;
                $image->move(public_path("productimages"),$imageName);
                $images[]=[
                        'name'=>$imageName,
                        'productid'=>$brand->id
                ];
            }
            Productimage::insert($images); 
        }
        
        return redirect()->route($this->redirect.".index");
    }
    public function delete(Request $req)
    {
        MainTable::destroy($req->cid);
        return redirect()->route($this->redirect.".index");
    }
    public function update(Request $req)
    {
        $categories=Category::all();
        $brands=Brand::all();
        $data=MainTable::find($req->cid); // select * from categories
        return View($this->table.".update",compact('brands','categories'))->with([$this->redirect=>$data]);
    }
    public function product(Request $req)
    {
        $product=MainTable::where('products.id',$req->cid)
        ->join('brands','brands.id','products.brandid')
        ->join('categories','categories.id','products.categoryid')
        ->select('products.*','categories.name as categoryname','brands.name as brandname')
        ->get();
        $images=Productimage::where('productid',$req->cid)->get();
     //   dd(DB::getQueryLog());
       // dd($product);
        return view($this->table.".product",compact('product','images')); 
    }
    public function updatedb(Request $req)
    {
        $brand=MainTable::find($req->cid);
        $brand->name=$req->name;
        $brand->price=$req->price;
        $brand->color=$req->color;
        $brand->categoryid=$req->categoryid;
        $brand->brandid=$req->brandid;
        $brand->size=$req->size;
        $brand->save();
        return redirect()->route($this->redirect.".index");
    }
}
