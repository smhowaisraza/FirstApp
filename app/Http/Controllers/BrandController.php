<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand as MainTable;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public $table="Brand";
    public $redirect="brand";
    public function index()
    {
        $data=MainTable::all(); // select * from categories
       // $product=Product::all(); // select * from categories
       // dd($data);
       return View($this->table.".index")->with([$this->redirect.'s'=>$data]);
     //  return View("Category.index",compact('data','product'));
    }
    public function add()
    {
        return View($this->table.".add");
    }
    public function adddb(Request $req)
    {
        $brand=new MainTable();
        $brand->name=$req->name;
        $brand->save();
        return redirect()->route($this->redirect.".index");
    }
    public function delete(Request $req)
    {
        MainTable::destroy($req->cid);
        return redirect()->route($this->redirect.".index");
    }
    public function update(Request $req)
    {
        $data=MainTable::find($req->cid); // select * from categories
        return View($this->table.".update")->with([$this->redirect=>$data]);
    }
    public function updatedb(Request $req)
    {
        $brand=MainTable::find($req->cid); 
        $brand->name=$req->name;
        $brand->save();
        return redirect()->route($this->redirect.".index");
    }
}
