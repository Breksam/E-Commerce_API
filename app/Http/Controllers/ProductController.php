<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        if($products){
            return response()->json($products);
        } else return response()->json("there's no product");
    }

     /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findorFail($id);
        return response()->json($product, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();

        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->is_trendy = $request->is_trendy;
        $product->is_available = $request->is_available;
        $product->price = $request->price;
        $product->amount = $request->amount;
        $product->discount = $request->discount;
        $image = $request->file('image')->store('products', 'images');
        $product->image = $image;
        $product->save();

        return response()->json("Product Added");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $product = Product::findorFail($id);

        $product->category_id = $request->category_id  == "" ? $product->category_id :$request->category_id;
        $product->brand_id = $request->brand_id  == "" ? $product->brand_id :$request->brand_id;
        $product->name = $request->name  == "" ? $product->name :$request->name;
        $product->is_trendy = $request->is_trendy  == "" ? $product->is_trendy :$request->is_trendy;
        $product->is_available = $request->is_available  == "" ? $product->is_available :$request->is_available;
        $product->price = $request->price  == "" ? $product->price :$request->price;
        $product->amount = $request->amount  == "" ? $product->amount :$request->amount;
        $product->discount = $request->discount  == "" ? $product->discount :$request->discount;
        $image = $request->file('image') == "" ? $product->image : $request->file('image')->store('products', 'images');
        $product->image = $image;
        $product->save();

        return response()->json("Product Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $product = Product::findorFail($id);
            $product->delete();
            return response()->json('Product deleted');
    }
}
