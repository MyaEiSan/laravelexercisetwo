<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index(){

        if(request()->ajax()){
            $packages = Package::all(); 
            return view('plans.packagelist',compact('packages'))->render();
        }
        return view('plans.index');
    }
}
