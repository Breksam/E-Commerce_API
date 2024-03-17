<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('users')->paginate('20');

        if($orders){
            foreach($orders as $order){
                foreach($order->items as $order_item){
                    $product = Product::where('id', $order_item->product_id)->pluck('name');
                    $order_item->product_name = $product['0'];
                }
            }
            return response()->json($orders, 200);

        }else return response()->json("there's no Orders");
    }

    public function show($id){
        $order = Order::findorFail($id);
        return response()->json($order, 200);
    }

    public function store(OrderRequest $request){
        try{
             
            foreach($request->order_items as $order_items)
            {
                $location = Location::where('user_id', Auth::id())->first();
                $product = Product::where('id', $order_items['product_id'])->first();
                if($product->amount >= $order_items['quantity'])
                {
                    $order_id = Order::insertGetId([
                        'user_id' => Auth::id(),
                        'location_id' => $location->id,
                        'total_price' => $request->total_price,
                        'date_of_delivery' => $request->date_of_delivery,
                    ]);

                    $items = new OrderItem();
                    $items->order_id = $order_id;
                    $items->price = $order_items['price'];
                    $items->product_id = $order_items['product_id'];
                    $items->quantity = $order_items['quantity'];
                    $items->save();

                    $product->amount = ($product->amount - $order_items['quantity']);
                    $product->save();

                }else return response()->json('Sorry, product amount is '.$product->amount.' not enought to ordered!'); 
            }
            return response()->json('Order Added');
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    public function get_order_items($id){
        $order_items = OrderItem::where('order_id',$id)->get();
        if($order_items){
            foreach($order_items as $order_item){
                $product = Product::where('id', $order_item->product_id)->pluck('name');
                $order_item->product_name = $product['0'];
            }
            return response()->json($order_items);
        }else return response()->json("No items found");
    }

    public function get_user_orders($id){
        $orders = Order::where('user_id', $id)
        ->with('items', function($query){
            $query->orderBy('created_at', 'desc');
        })->get();

        if($orders){
            foreach($orders as $order ){
                foreach($order->items as $order_item){
                    $product = Product::where('id', $order_item->product_id)->pluck('name');
                    $order_item->product_name = $product['0'];
                }
            }
            return response()->json($orders);
        }else return response()->json("No orders found for this user");
    }

    public function change_order_status($id, Request $request){
        $order = Order::findorFail($id);
        $order->update(['status' => $request->status]);
        return response()->json("Status changed successfully");
    }
}
