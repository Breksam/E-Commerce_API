<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function store(LocationRequest $request){
        Location::create([
            'user_id' => Auth::id(),
            'building' => $request->building,
            'street' => $request->street,
            'area' => $request->area,
        ]);
        return response()->json('Location Added', 200);
    }

    public function update($id, Request $request){
        $location = Location::findorFail($id);
        if($location){
            $location->building = $request->building  == ''? $location->building :$request->building;
            $location->street = $request->street  == ''? $location->street :$request->street;
            $location->area = $request->area  == ''? $location->area :$request->area;
            $location->save();
            return response()->json('Location Updated');
        }
        else return response()->json('Location not found ');

       
    }

    public function delete($id){
        $location = Location::findorFail($id);
        if($location){
            $location->delete();
            return response()->json('Location Deleted');
        }
        else return response()->json('Location not found ');
    }

}
