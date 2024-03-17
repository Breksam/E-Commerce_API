<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $Categories = Category::paginate(10);
        return response()->json($Categories, 200);
    }

    public function show($id){
        $category = Category::findorFail($id);
        return response()->json($category, 200);
    }

    public function store(Request $request){
        try{
            $validated = $request->validate([
                'name' => 'required|unique:categories,name',
                'image' => 'required'
            ]);
            $category = new Category();

            $category->name = $request->name;
            $image = $request->file('image')->store('categories', 'images');
            $category->image = $image;
            $category->save();

            return response()->json('Category added', 201);
        }catch(Exception $e){
            return response()->json($e, 500);
        }
    }

    public function update($id, Request $request){
        try{
            $category = Category::findorFail($id);
            
            $image = $request->file('image') == null ? $category->image : $request->file('image')->store('categories', 'images') ;
            $category->image = $image;
            $category->name = $request->name  == null ? $category->name :$request->name;
            $category->update();

            return response()->json('Category updated', 201);
        }catch(Exception $e){
            return response()->json($e, 500);
        }
    }

    public function delete($id){
        $category = Category::findorFail($id);
        $category->delete();
        return response()->json('Category deleted');
    }
}
