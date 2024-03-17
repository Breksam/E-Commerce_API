<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::paginate(10);
        return response()->json($brands, 200);
    }

    public function show($id){
        $brand = Brand::findorFail($id);
        if($brand)
            return response()->json($brand, 200);
        else
            return response()->json('brand not found');
    }

    public function store(Request $request){
        try{
            $validated = $request->validate([
                'name' => 'required|unique:brands,name'
            ]);
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->save();
            return response()->json('Brand added', 201);
        }catch(Exception $e){
            return response()->json($e, 500);
        }
    }

    public function update($id, Request $request){
        try{
            $validated = $request->validate([
                'name' => 'required|unique:brands,name'
            ]);
            
            Brand::where('id', $id)->update([
                'name'=> $request->name
            ]);

            return response()->json('Brand updated', 201);
        }catch(Exception $e){
            return response()->json($e, 500);
        }
    }

    public function delete($id){
        $brand = Brand::findorFail($id);
        if($brand){
            $brand->delete();
            return response()->json('Brand deleted');
        }else{
            return response()->json('Brand not found');
        }
    }
}
