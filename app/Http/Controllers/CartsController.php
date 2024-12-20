<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Package;
use App\Models\UserPoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{
    public function index(){
        $user = Auth::user();
        $user_id = $user->id; 
        $carts = Cart::where('user_id',$user_id)->get(); 
        $totalcost = $this->gettotalcost($carts);

        return view('carts.index',compact('carts','totalcost'));
    }

    private function gettotalcost($carts){

        $totalcost = 0; 

        foreach($carts as $cart){
            $totalcost += $cart->quantity * $cart->price;
        }

        return $totalcost;
    }

    public function  add(Request $request){

        $user_id = auth()->id(); 

        Cart::updateOrCreate([
            'user_id' => $user_id, 
            'package_id' => $request->package_id,
            'quantity' => $request->input('quantity'),
            // 'quantity' =>  DB::raw('quantity +'. $request->input('quantity')), 
            'price' => $request->input('price')
        ]);

        return response()->json(['message'=>'Product added to cart successfully']);

    }

    public function  remove(Request $request){

        $user = Auth::user(); 
        $user_id = $user->id;
        $packageid = $request->packageid;

        $cart = Cart::where('user_id',$user_id)->where('package_id',$packageid)->first();
        $cart->delete();

        return response()->json(['message'=>'Removed from cart successfully']);
        
    }

    public function  paybypoints(Request $request){

        $user = Auth::user();
        $user_id = $user->id; 
        $carts = Cart::where('user_id',$user_id)->get();
        $isextend = false; 

        $totalcost = $carts->sum(function($cart){

            return $cart->price * $cart->quantity;
        });

        $packageid = $request->packageid;
        $package = Package::findOrFail($packageid); 
        $userpoinsts = UserPoint::where('user_id',$user_id)->first(); 

        if($userpoinsts && $userpoinsts->points>= $totalcost){

            // deduct points 
            $userpoinsts->points -= $totalcost;
            $userpoinsts->save();

            if($user->subscription_expires_at >= Carbon::now()){
                // extend package 

                $isextend = true; 

                $user->package_id = $packageid; 
                $user->subscription_expires_at = Carbon::parse($user->subscription_expires_at)->addDays($package->duration);
                $user->save();

            }else{
                // renew new package 

                $isextend = false; 
                $user->subscription_expires_at = Carbon::now()->addDay($package->duration);
                $user->save();
            }

            // create invoice 

            // remove cart 
            Cart::where('user_id',$user_id)->delete();
            // $carts->each->delete();

        return response()->json(['message'=>$isextend?'Package extended successfully':'New Package added'],200);


        }

        return response()->json(['message'=>'Insufficient points!'],400);
    }
}
