<?php

namespace App\Http\Controllers;

use App\Models\Paymentmethod;
use Illuminate\Http\Request;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PgSql\Lob;

class PaymentmethodsController extends Controller
{
    public function index()
    {
        $paymentmethods = Paymentmethod::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('paymentmethods.index',compact('paymentmethods','statuses'));
    }

    public function create()
    {
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('types.create',compact('statuses'));
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:50|unique:types,name',
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        // dd($request['status_id']);

        $paymentmethod = new Paymentmethod();
        $paymentmethod->name = $request['name'];
        $paymentmethod->slug = Str::slug($request['name']);
        $paymentmethod->status_id = $request['status_id'];
        $paymentmethod->user_id = $user->id;

        $paymentmethod->save();

        return redirect(route('paymentmethods.index'));
    }

    
    public function show(string $id)
    {
        $paymentmethod = Paymentmethod::findOrFail($id);
        return view('paymentme$paymentmethods.show',["paymentme$paymentmethod"=>$paymentmethod]);
    }

    
    public function edit(string $id)
    {
        $paymentmethod = Paymentmethod::findOrFail($id);
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('paymentmethods.edit')->with("paymentmethod",$paymentmethod)->with('statuses',$statuses);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => ['required','max:50','unique:types,name,'.$id],
            'status_id' => ['required','in:3,4']
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $paymentmethod = Paymentmethod::findOrFail($id);
        $paymentmethod->name = $request['name'];
        $paymentmethod->slug = Str::slug($request['name']);
        $paymentmethod->status_id = $request['status_id'];
        $paymentmethod->user_id = $user->id;


        $paymentmethod->save();

        return redirect(route('paymentmethods.index'));
    }

    
    // public function destroy(string $id)
    // {
    //     $type = Type::findOrFail($id);
            
    //     $type->delete();

    //     return redirect()->back();
    // }

    public function destroy(Paymentmethod $paymentmethod)
    {
        try{
            if($paymentmethod){
                $paymentmethod->delete();
                return response()->json(["status"=>"success","data"=>$paymentmethod,"message"=>"Delete Successfully"]);
            }

            return response()->json(["status"=>"failed","message"=>"No Data Found"]);
            
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

    public function typestatus(Request $request){ 

        $type = Paymentmethod::findOrFail($request['id']);
        $type->status_id = $request['status_id'];
        $type->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }
}
