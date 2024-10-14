<?php

namespace App\Http\Controllers;

use App\Models\Paymentmethod;
use App\Models\Paymenttype;
use Illuminate\Http\Request;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentmethodsController extends Controller
{
    public function index()
    {
        $paymentmethods = Paymentmethod::all();
        $paymenttypes = Paymenttype::where('status_id',3)->get();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('paymentmethods.index',compact('paymentmethods','statuses','paymenttypes'));
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
            'paymenttype_id' => 'required',
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        try{
            
            $paymentmethod = new Paymentmethod();
            $paymentmethod->name = $request['name'];
            $paymentmethod->slug = Str::slug($request['name']);
            $paymentmethod->paymenttype_id = $request['paymenttype_id'];
            $paymentmethod->status_id = $request['status_id'];
            $paymentmethod->user_id = $user->id;

            $paymentmethod->save();

            $paymentmethod = $paymentmethod->load('paymenttype','user');

            if($paymentmethod){
                return response()->json(["status"=>"success","data"=>$paymentmethod]);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }

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
            'editname' => ['required','max:50','unique:paymentmethods,name,'.$id],
            'editpaymenttype_id' => 'required',
            'editstatus_id' => ['required','in:3,4']
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        try{
            
            $paymentmethod = Paymentmethod::findOrFail($id);
            $paymentmethod->name = $request['editname'];
            $paymentmethod->slug = Str::slug($request['editname']);
            $paymentmethod->paymenttype_id = $request['editpaymenttype_id'];
            $paymentmethod->status_id = $request['editstatus_id'];
            $paymentmethod->user_id = $user->id;


            $paymentmethod->save();

            $paymentmethod = $paymentmethod->load('paymenttype','user');

            if($paymentmethod){
                return response()->json(['status'=>'success','data'=>$paymentmethod]);
            }

            return response()->json(['status'=>'failed','message'=>'Failed to update Payment Method']);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'success','message'=>$e->getMessage()]);
        }


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

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $paymentmethod = Paymentmethod::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
