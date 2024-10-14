<?php

namespace App\Http\Controllers;

use App\Models\Paymenttype;
use Illuminate\Http\Request;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymenttypesController extends Controller
{
    public function index()
    {
        $paymenttypes = Paymenttype::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('paymenttypes.index',compact('paymenttypes','statuses'));
    }

    public function create()
    {
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('paymenttypes.create',compact('statuses'));
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

        try{
            
            $payemnttype = new Paymenttype();
            $payemnttype->name = $request['name'];
            $payemnttype->slug = Str::slug($request['name']);
            $payemnttype->status_id = $request['status_id'];
            $payemnttype->user_id = $user->id;

            $payemnttype->save();

            if($payemnttype){
                return response()->json(["status"=>"success","data"=>$payemnttype]);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }

    }

    
    public function show(string $id)
    {
        $paymentmethod = Paymenttype::findOrFail($id);
        return view('paymentme$paymentmethods.show',["paymentme$paymentmethod"=>$paymentmethod]);
    }

    
    public function edit(string $id)
    {
        $paymentmethod = Paymenttype::findOrFail($id);
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

        try{
            
            $payemnttype = Paymenttype::findOrFail($id);
            $payemnttype->name = $request['name'];
            $payemnttype->slug = Str::slug($request['name']);
            $payemnttype->status_id = $request['status_id'];
            $payemnttype->user_id = $user->id;


            $payemnttype->save();

            if($payemnttype){
                return response()->json(['status'=>'success','data'=>$payemnttype]);
            }

            return response()->json(['status'=>'failed','message'=>'Failed to update Payment Method']);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'success','message'=>$e->getMessage()]);
        }


        return redirect(route('paymenttypes.index'));
    }

    
    // public function destroy(string $id)
    // {
    //     $type = Type::findOrFail($id);
            
    //     $type->delete();

    //     return redirect()->back();
    // }

    public function destroy(Paymenttype $paymenttype)
    {
        try{
            if($paymenttype){
                $paymenttype->delete();
                return response()->json(["status"=>"success","data"=>$paymenttype,"message"=>"Delete Successfully"]);
            }

            return response()->json(["status"=>"failed","message"=>"No Data Found"]);
            
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

    public function typestatus(Request $request){ 

        $type = Paymenttype::findOrFail($request['id']);
        $type->status_id = $request['status_id'];
        $type->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $paymenttype = Paymenttype::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
